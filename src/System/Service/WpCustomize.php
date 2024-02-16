<?php declare(strict_types=1);
namespace System\Service;

use System\Models\CustomField;
use System\Models\CustomPostType;

final class WpCustomize
{
    private static array $registered_posts = [];

    private static array $registered_fields = [];

    public static function addCustomPostType(string $class_name): void
    {
        $post_slug = self::addPostType($class_name);
        self::addCustomFields($class_name, $post_slug);
    }

    public static function addPostType(string $class_name): string
    {
        $slug = CustomPostType::getSlug($class_name);
        $title = CustomPostType::getTitle($class_name);
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
        $property_names = CustomField::getCustomFieldNames($class_name);
        foreach ($property_names as $property_name) {
            $slug = CustomField::getSlug($class_name, $property_name);
            $title = CustomField::getTitle($class_name, $property_name);
            self::addCustomField($post_slug, $slug, $title);
        }
    }

    private static function addCustomField(string|array $post_slug, string $field_slug, string $title): void
    {
        $slug = $post_slug . '_' . $field_slug;
        $nonce = '_wp_nonce_' . $field_slug;
        $id = $field_slug . '_id';
        $name = $field_slug . '_name';
        if (!array_key_exists($slug, self::$registered_fields)) {
            add_action('add_meta_boxes', function () use ($slug, $post_slug, $nonce, $id, $name, $field_slug, $title) {
                add_meta_box(
                    $slug,
                    $title,
                    function () use ($nonce, $id, $name, $field_slug) {
                        $value = esc_attr(get_post_meta(get_the_ID(), $field_slug, true));
                        wp_nonce_field('wp-nonce-key', $nonce);
                        echo "<div class=\"{$field_slug}\">";
                        echo "<input type=\"text\" value=\"{$value}\" id=\"{$id}\" name=\"{$name}\">";
                        echo "</div>";
                    },
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
            self::$registered_fields[$slug] = true;
        }
    }
}