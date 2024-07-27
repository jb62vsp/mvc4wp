<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

use Mvc4Wp\Core\Library\DateTimeUtils;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\CustomPostType;
use Mvc4Wp\Core\Model\Attribute\CustomTaxonomy;
use Mvc4Wp\Core\Model\Attribute\UserCustomField;
use Mvc4Wp\Core\Service\App;

final class WordPressCustomize
{
    private static array $registered_posts = [];

    private static array $registered_fields = [];

    private static array $registered_taxonomies = [];

    private static array $added_callback = [];

    public static function addCustomFields(string $class_name, string $post_slug): void
    {
        $property_names = CustomField::getAttributedPropertyNames($class_name);
        foreach ($property_names as $property_name) {
            $attr = CustomField::getPropertyAttribute($class_name, $property_name);
            $field_slug = $property_name;
            $title = $attr->title;
            $type = $attr->type;
            $slug = $post_slug . '_' . $field_slug;
            if (!array_key_exists($slug, self::$registered_fields)) {
                $callback = self::createCustomPostAdminField($type, $field_slug);
                self::addCustomField($slug, $post_slug, $field_slug, $title, $callback);
                self::$registered_fields[$slug] = true;
            }
        }
    }

    public static function addCustomPostType(string $class_name): void
    {
        $post_slug = self::addPostType($class_name);
        self::addCustomFields($class_name, $post_slug);
    }

    public static function addCustomTaxonomy(string $class_name): void
    {
        $tax_slug = self::addTaxonomy($class_name);
        self::addCustomTaxonomyFields($class_name, $tax_slug);
    }

    public static function addCustomTaxonomyFields(string $class_name, string $tax_slug): void
    {
        $property_names = CustomField::getAttributedPropertyNames($class_name);
        foreach ($property_names as $property_name) {
            $attr = CustomField::getPropertyAttribute($class_name, $property_name);
            $field_slug = $property_name;
            $title = $attr->title;
            $type = $attr->type;
            $slug = $tax_slug . '_' . $field_slug;
            if (!array_key_exists($slug, self::$registered_fields)) {
                $callback = self::createCustomTaxonomyAdminField($type, $field_slug, $title);
                self::addTaxonomyCustomField($slug, $tax_slug, $field_slug, $title, $callback);
                self::$registered_fields[$slug] = true;
            }
        }
    }

    public static function addPostType(string $class_name): string
    {
        $attr = CustomPostType::getClassAttribute($class_name);
        $slug = $attr->name;
        if (!array_key_exists($slug, self::$registered_posts)) {
            $default = [
                'label' => $attr->title,
                'public' => true, // wordpress default: false
                'show_in_rest' => false, // wordpress default: true
                'menu_position' => 5, // wordpress default: null
                'supports' => ['title'], // wordpress default: title, editor
                'taxonomies' => ['category', 'post_tag'], // wordpress default: []
            ];
            $args = array_merge($default, $attr->args);
            add_action('init', function () use ($slug, $args) {
                register_post_type($slug, $args);
            });
            self::$registered_posts[$slug] = true;
        }

        return $slug;
    }

    public static function addTaxonomy(string $class_name): string
    {
        $attr = CustomTaxonomy::getClassAttribute($class_name);
        $slug = $attr->name;
        $title = $attr->title;
        $targets = $attr->targets;
        if (!array_key_exists($slug, self::$registered_taxonomies)) {
            $default = [
                'label' => $attr->title,
                'show_in_rest' => true, // wordpress default: true
                'hierarchical' => $attr->hierarhical,
            ];
            $args = array_merge($default, $attr->args);
            add_action('init', function () use ($slug, $targets, $args) {
                register_taxonomy($slug, $targets, $args);
            });

            foreach ($targets as $target) {
                $custom_column = function ($columns) use ($slug, $title) {
                    $columns[$slug] = $title;
                    return $columns;
                };
                add_filter('manage_' . $target . '_posts_columns', $custom_column);

                add_action('manage_' . $target . '_posts_custom_column', function ($column, $id) use ($slug) {
                    if ($column === $slug) {
                        $terms = get_the_terms($id, $column);
                        if ($terms && !is_wp_error($terms)) {
                            echo join(", ", array_map(fn($v) => $v->name, get_the_terms($id, $column))); // TODO: 絞り込みリンクの作成
                        } else {
                            echo '—';
                        }
                    }
                }, 10, 2);

                $my_add_filter = function () use ($target, $slug, $title) {
                    global $post_type;
                    if ($target === $post_type) {
                        echo "<select name='{$slug}'>";
                        echo "<option value=''>すべての{$title}</option>";
                        foreach (get_terms($slug) as $term) {
                            $selected = (isset($_GET[$slug]) && $_GET[$slug] === $term->slug) ? 'selected' : '';
                            echo "<option value='{$term->slug}' {$selected}>{$term->name}</option>";
                        }
                        echo "</select>";
                    }
                };
                add_action('restrict_manage_posts', $my_add_filter);
            }

            self::$registered_taxonomies[$slug] = true;
        }

        return $slug;
    }

    public static function addCustomUserField(string $class_name): void
    {
        $property_names = UserCustomField::getAttributedPropertyNames($class_name);
        foreach ($property_names as $property_name) {
            $attr = UserCustomField::getPropertyAttribute($class_name, $property_name);
            $field_slug = $property_name;
            $title = $attr->title;
            add_filter('user_contactmethods', function (array $methods) use ($field_slug, $title): array {
                $methods[$field_slug] = $title;
                return $methods;
            });
        }
    }

    public static function changeLoginUrl(string $controller_class, string $login_name = 'login', string $logout_name = 'logout', string $redirect_uri = '/'): void
    {
        add_action('login_init', function () use ($login_name) {
            $uri = $_SERVER['REQUEST_URI'];
            if (str_contains($uri, 'wp-login.php')) {
                wp_safe_redirect('/' . $login_name);
            }
        });
        add_action('template_redirect', function () use ($controller_class, $login_name) {
            if ($_SERVER["REQUEST_URI"] === '/' . $login_name) {
                App::get()->router()->GET('/' . $login_name, [$controller_class]);
                App::get()->router()->POST('/' . $login_name, [$controller_class, $login_name]);
                App::get()->run();
            }
        });
        add_filter('login_redirect', function () use ($redirect_uri) {
            return $redirect_uri;
        });
        add_filter('site_url', function ($url, $path) use ($login_name, $logout_name) {
            if (str_contains($path, 'wp-login.php?action=logout')) {
                $url = '/' . $logout_name;
            } elseif (str_contains($path, 'wp-login.php')) {
                $url = '/' . $login_name;
            }
            return $url;
        }, 10, 2);
        add_filter('wp_redirect', function ($location) use ($login_name) {
            if (str_contains($location, $login_name)) {
                $location = '/' . $login_name;
            }
            return $location;
        });
    }

    public static function disableRedirectCanonical(): void
    {
        self::add_filter('redirect_canonical', fn($url) => (is_404()) ? false : $url);
    }

    public static function disableTraceSQL(): void
    {
        self::remove_filter('query');
    }

    public static function enableRedirectCanonical(): void
    {
        self::remove_filter('redirect_canonical');
    }

    public static function enableTraceSQL(callable $callback): void
    {
        self::add_filter('query', $callback);
    }

    private static function add_filter(string $key, callable $callback): void
    {
        add_filter($key, $callback);
        if (array_key_exists($key, self::$added_callback)) {
            self::$added_callback[$key][] = $callback;
        } else {
            self::$added_callback[$key] = [$callback];
        }
    }

    private static function remove_filter(string $key): void
    {
        if (array_key_exists($key, self::$added_callback)) {
            foreach (self::$added_callback[$key] as $callback) {
                remove_filter($key, $callback);
            }
            unset(self::$added_callback[$key]);
        }
    }

    private static function createCustomPostAdminField(string $type, string $field_slug): callable
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

    /**
     * @return array{0: callable, 1: callable}
     */
    private static function createCustomTaxonomyAdminField(string $type, string $field_slug, $title): array
    {
        if (is_user_logged_in() && is_admin()) {
            $id = $field_slug . '_id';
            $name = $field_slug . '_name';
            $nonce = '_wp_nonce_' . $field_slug;
            $result = match ($type) {
                default => self::createTaxTextField($field_slug, $title, $id, $name, $nonce),
            };
            return $result;
        } else {
            return [function () { /* noop */}, function () { /* noop */}];
        }
    }

    private static function addCustomField(string $slug, string $post_slug, string $field_slug, string $title, callable $callback): void
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

            $value = esc_attr($_POST[$name]);
            add_post_meta($post_id, $field_slug, $value, true);
            update_post_meta($post_id, $field_slug, $value);
        });

        add_action('manage_' . $post_slug . '_posts_columns', function ($columns) use ($field_slug, $title) {
            $columns[$field_slug] = $title;
            return $columns;
        });

        add_action('manage_' . $post_slug . '_posts_custom_column', function ($column, $post_id) use ($field_slug) {
            if ($column === $field_slug) {
                echo get_post_meta($post_id, $column, true);
            }
        }, 10, 2);

        // TODO: ソート機能
    }

    private static function addTaxonomyCustomField(string $slug, string $tax_slug, string $field_slug, string $title, array $callback): void
    {
        $name = $field_slug . '_name';
        $nonce = '_wp_nonce_' . $field_slug;

        add_action("{$tax_slug}_add_form_fields", $callback[0]);
        add_action("{$tax_slug}_edit_form_fields", $callback[1]);
        add_action('create_term', function ($term_id) use ($nonce, $name, $field_slug) {
            if (!isset($_POST[$nonce]) || !$_POST[$nonce]) {
                return;
            }
            if (!check_admin_referer('wp-nonce-key', $nonce)) {
                return;
            }
            if (!isset($_POST[$name])) {
                return;
            }

            $value = esc_attr($_POST[$name]);
            update_term_meta($term_id, $field_slug, $value);
        });

        add_action('edit_terms', function ($term_id) use ($nonce, $name, $field_slug) {
            if (!isset($_POST[$nonce]) || !$_POST[$nonce]) {
                return;
            }
            if (!check_admin_referer('wp-nonce-key', $nonce)) {
                return;
            }
            if (!isset($_POST[$name])) {
                return;
            }

            $value = esc_attr($_POST[$name]);
            update_term_meta($term_id, $field_slug, $value);
        });
    }

    private static function createTextField(string $field_slug, string $id, string $name, string $nonce): callable
    {
        return function () use ($field_slug, $id, $name, $nonce) {
            $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='text' id='{$id}' name='{$name}' value='{$value}' style='width: 100%;'>";
            echo "</div>";
        };
    }

    private static function createTextAreaField(string $field_slug, string $id, string $name, string $nonce): callable
    {
        return function () use ($nonce, $id, $name, $field_slug) {
            $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<textarea id='{$id}' name='{$name}' rows='8' style='width: 100%;'>{$value}</textarea>";
            echo "</div>";
        };
    }

    private static function createIntegerField(string $field_slug, string $id, string $name, string $nonce): callable
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

    private static function createUnsignedIntegerField(string $field_slug, string $id, string $name, string $nonce): callable
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

    private static function createFloatField(string $field_slug, string $id, string $name, string $nonce): callable
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

    private static function createUnsignedFloatField(string $field_slug, string $id, string $name, string $nonce): callable
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

    private static function createBoolField(string $field_slug, string $id, string $name, string $nonce): callable
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

    private static function createDateField(string $field_slug, string $id, string $name, string $nonce): callable
    {
        return function () use ($field_slug, $id, $name, $nonce) {
            $value = DateTimeUtils::datetimeval(get_post_meta(get_the_ID(), $field_slug, true));
            $formed_value = DateTimeUtils::strval($value, 'Y-m-d');
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='date' id='{$id}' name='{$name}' value='{$formed_value}' min='1900-01-01' max='9999-12-31'>";
            echo "</div>";
        };
    }

    private static function createTimeField(string $field_slug, string $id, string $name, string $nonce): callable
    {
        return function () use ($field_slug, $id, $name, $nonce) {
            $value = DateTimeUtils::datetimeval(get_post_meta(get_the_ID(), $field_slug, true));
            $formed_value = DateTimeUtils::strval($value, 'H:i:s');
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='time' id='{$id}' name='{$name}' value='{$formed_value}' step='1'>";
            echo "</div>";
        };
    }

    private static function createDateTimeField(string $field_slug, string $id, string $name, string $nonce): callable
    {
        return function () use ($field_slug, $id, $name, $nonce) {
            $value = DateTimeUtils::datetimeval(get_post_meta(get_the_ID(), $field_slug, true));
            $formed_value = DateTimeUtils::strval($value, 'Y-m-d H:i:s');
            $values = explode(' ', $formed_value);
            wp_nonce_field('wp-nonce-key', $nonce);
            echo "<div class='{$field_slug}'>";
            echo "<input type='date' id='{$id}_date' name='{$name}_date' value='{$values[0]}' min='1900-01-01' max='9999-12-31'>";
            echo "<input type='time' id='{$id}_time' name='{$name}_time' value='{$values[1]}' step='1'>";
            echo "<input type='hidden' id='{$id}' name='{$name}' value'{$formed_value}'>";
            ?>
            <script>{ const id = '<?php echo $id; ?>'; const date_id = id + '_date'; const time_id = id + '_time'; const input = document.querySelector('#' + id); const input_date = document.querySelector('#' + date_id); const input_time = document.querySelector('#' + time_id); const onchange = (ev) => { input.value = input_date.value + ' ' + input_time.value; }; input_date.addEventListener('change', onchange); input_time.addEventListener('change', onchange); }</script>
            <?php
            echo "</div>";
        };
    }

    /**
     * @return array{0: callable, 1: callable}
     */
    private static function createTaxTextField(string $field_slug, string $title, string $id, string $name, string $nonce): array
    {
        return [
            function ($term) use ($field_slug, $title, $id, $name, $nonce) {
                wp_nonce_field('wp-nonce-key', $nonce);
                echo "<div class='form-field {$field_slug}'>";
                echo "<label for='{$id}'>{$title}</label>";
                echo "<input type='text' id='{$id}' name='{$name}' size='40'>";
                echo "</div>";
            },
            function ($term) use ($field_slug, $title, $id, $name, $nonce) {
                $value = esc_attr(get_term_meta($term->term_id, $field_slug, true));
                wp_nonce_field('wp-nonce-key', $nonce);
                echo "<tr class='form-field'>";
                echo "<th><label for='{$id}'>{$title}</label></th>";
                echo "<td><input type='text' id='{$id}'  name='{$name}' value='{$value}' size='40'></td>";
                echo "</tr>";
            },
        ];
    }
}