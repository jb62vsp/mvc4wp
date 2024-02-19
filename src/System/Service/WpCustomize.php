<?php declare(strict_types=1);
namespace Wp4Mvc\System\Service;

use Wp4Mvc\System\Helper\DateTimeHelper;
use Wp4Mvc\System\Models\CustomField;
use Wp4Mvc\System\Models\CustomPostType;

final class WpCustomize
{
    private static array $registered_posts = [];

    private static array $registered_fields = [];

    public static function disableRedirectCanonical(): void
    {
        add_filter('redirect_canonical', fn($url) => (is_404()) ? false : $url);
    }

    public static function addCustomPostType(string $class_name): void
    {
        $post_slug = self::addPostType($class_name);
        self::addCustomFields($class_name, $post_slug);
    }

    public static function addPostType(string $class_name): string
    {
        $attr = CustomPostType::getClassAttribute($class_name);
        $slug = $attr->name;
        $title = $attr->title;
        if (!array_key_exists($slug, self::$registered_posts)) {
            add_action('init', function () use ($slug, $title) {
                register_post_type($slug, [
                    'label' => $title,
                    'public' => true,
                    'has_archive' => false,
                    'menu_position' => 5,
                    'show_in_rest' => false,
                ]);
            });
            self::$registered_posts[$slug] = true;
        }

        return $slug;
    }

    public static function addCustomFields(string $class_name, string|array $post_slug): void
    {
        $property_names = CustomField::getAttributedPropertyNames($class_name);
        foreach ($property_names as $property_name) {
            $attr = CustomField::getPropertyAttribute($class_name, $property_name);
            $field_slug = $attr->name;
            $title = $attr->title;
            $type = $attr->type;
            $slug = $post_slug . '_' . $field_slug;
            if (!array_key_exists($slug, self::$registered_fields)) {
                $callback = self::createAdminField($type, $field_slug);
                self::addCustomField($slug, $post_slug, $field_slug, $title, $callback);
                self::$registered_fields[$slug] = true;
            }
        }
    }

    private static function createAdminField(string $type, string $field_slug)
    {
        if (is_user_logged_in() && is_admin()) {
            $id = $field_slug . '_id';
            $name = $field_slug . '_name';
            $nonce = '_wp_nonce_' . $field_slug;
            $result = match ($type) {
                CustomField::TEXT => self::createTextField($field_slug, $id, $name, $nonce),
                CustomField::TEXTAREA => self::createTextAreaField($field_slug, $id, $name, $nonce),
                CustomField::INTEGER => self::createIntegerField($field_slug, $id, $name, $nonce),
                CustomField::UINTEGER => self::createUnsignedIntegerField($field_slug, $id, $name, $nonce),
                CustomField::FLOAT => self::createFloatField($field_slug, $id, $name, $nonce),
                CustomField::UFLOAT => self::createUnsignedFloatField($field_slug, $id, $name, $nonce),
                CustomField::BOOL => self::createBoolField($field_slug, $id, $name, $nonce),
                CustomField::DATE => self::createDateField($field_slug, $id, $name, $nonce),
                CustomField::TIME => self::createTimeField($field_slug, $id, $name, $nonce),
                CustomField::DATETIME => self::createDateTimeField($field_slug, $id, $name, $nonce),
                default => self::createTextField($field_slug, $id, $name, $nonce),
            };
            return $result;
        } else {
            return function () { /* noop */};
        }
    }

    private static function addCustomField(string $slug, string $post_slug, string $field_slug, string $title, $callback): void
    {
        $name = $field_slug . '_name';
        $nonce = '_wp_nonce_' . $field_slug;
        add_action('add_meta_boxes', function () use ($slug, $post_slug, $title, $callback) {
            add_meta_box(
                $slug,
                $title,
                $callback,
                screen: $post_slug,
                context: 'advanced',
                priority: 'default',
                callback_args: null,
            );
        });

        add_action('save_post', function ($post_id) use ($nonce, $name, $field_slug) {
            if (!isset($_POST[$nonce]) || !$_POST[$nonce]) {
                return;
            }
            if (!check_admin_referer('wp-nonce-key', $nonce)) {
                return;
            }
            if (!isset($_POST[$name])) {
                return;
            }

            $value = $_POST[$name];
            add_post_meta($post_id, $field_slug, $value, true);
            update_post_meta($post_id, $field_slug, $value);
        });
    }

    private static function createTextField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($field_slug, $id, $name, $nonce) {
            $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='text' id='{$id}' name='{$name}' value='{$value}' style='width: 100%;'>";
            echo "</div>";
        };
    }

    private static function createTextAreaField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($nonce, $id, $name, $field_slug) {
            $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<textarea id='{$id}' name='{$name}' rows='8' style='width: 100%;'>{$value}</textarea>";
            echo "</div>";
        };
    }

    private static function createIntegerField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($nonce, $id, $name, $field_slug) {
            $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='number' step='1' id='{$id}' name='{$name}' value='{$value}'>";
            echo "<span>※正負の整数のみ入力できます。</span>";
            echo "</div>";
        };
    }

    private static function createUnsignedIntegerField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($nonce, $id, $name, $field_slug) {
            $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='number' step='1' id='{$id}' name='{$name}' value='{$value}' min='0'>";
            echo "<span>※正の整数のみ入力できます。</span>";
            echo "</div>";
        };
    }

    private static function createFloatField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($nonce, $id, $name, $field_slug) {
            $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='number' step='any' id='{$id}' name='{$name}' value='{$value}'>";
            echo "<span>※正負の整数、小数のみ入力できます。</span>";
            echo "</div>";
        };
    }

    private static function createUnsignedFloatField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($nonce, $id, $name, $field_slug) {
            $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='number' step='any' id='{$id}' name='{$name}' value='{$value}' min='0'>";
            echo "<span>※正の整数、小数のみ入力できます。</span>";
            echo "</div>";
        };
    }

    private static function createBoolField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($nonce, $id, $name, $field_slug) {
            $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='radio' id='{$id}_false' name='{$name}' value='' " . ($value === '' ? 'checked' : '') . ">";
            echo "<label for='{$id}_false'>false</label>";
            echo "<input type='radio' id='{$id}_true' name='{$name}' value='1'" . ($value === '1' ? 'checked' : '') . ">";
            echo "<label for='{$id}_true'>true</label>";
            echo "</div>";
        };
    }

    private static function createDateField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($field_slug, $id, $name, $nonce) {
            $value = DateTimeHelper::datetimeval(get_post_meta(get_the_ID(), $field_slug, true));
            $formed_value = DateTimeHelper::strval($value, DateTimeHelper::DATE_FORMAT);
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='date' id='{$id}' name='{$name}' value='{$formed_value}' min='1900-01-01' max='9999-12-31'>";
            echo "</div>";
        };
    }

    private static function createTimeField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($field_slug, $id, $name, $nonce) {
            $value = DateTimeHelper::datetimeval(get_post_meta(get_the_ID(), $field_slug, true));
            $formed_value = DateTimeHelper::strval($value, DateTimeHelper::TIME_FORMAT);
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='time' id='{$id}' name='{$name}' value='{$formed_value}' step='1'>";
            echo "</div>";
        };
    }

    private static function createDateTimeField(string $field_slug, string $id, string $name, string $nonce)
    {
        return function () use ($field_slug, $id, $name, $nonce) {
            $value = DateTimeHelper::datetimeval(get_post_meta(get_the_ID(), $field_slug, true));
            $formed_value = DateTimeHelper::strval($value, DateTimeHelper::DATETIME_FORMAT);
            $values = explode(' ', $formed_value);
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='date' id='{$id}_date' name='{$name}_date' value='{$values[0]}' min='1900-01-01' max='9999-12-31'>";
            echo "<input type='time' id='{$id}_time' name='{$name}_time' value='{$values[1]}' step='1'>";
            echo "<input type='hidden' id='{$id}' name='{$name}' value'{$formed_value}'>";
            ?>
            <script>
                {
                    const id = '<?php echo $id; ?>';
                    const date_id = id + '_date';
                    const time_id = id + '_time';
                    const input = document.querySelector('#' + id);
                    const input_date = document.querySelector('#' + date_id);
                    const input_time = document.querySelector('#' + time_id);
                    const onchange = (ev) => {
                        input.value = input_date.value + ' ' + input_time.value;
                    };
                    input_date.addEventListener('change', onchange);
                    input_time.addEventListener('change', onchange);
                }
            </script>
            <?php
            echo "</div>";
        };
    }
}