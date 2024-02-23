<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\Field;
use Mvc4Wp\Core\Model\Attribute\PostType;
use Mvc4Wp\Core\Model\Repository\PostQueryBuilder;

#[PostType(name: 'post')]
class PostEntity extends Entity
{
    use Castable;

    #[Field]
    public int $post_author;

    #[Field]
    public string $post_date;

    #[Field]
    public string $post_name;

    #[Field]
    public string $post_status;

    #[Field]
    public string $post_title;

    #[Field]
    public string $post_type;

    #[Field]
    public string $post_content;

    public function __construct()
    {
        $this->post_type = PostType::getName(static::class);
    }

    public static function find(): PostQueryBuilder
    {
        $result = new PostQueryBuilder(static::class);
        return $result;
    }

    public function register(bool $publish = true): int
    {
        if ($publish) {
            $this->post_status = 'publish';
        }
        $id = wp_insert_post($this);
        $this->bind(['ID' => $id], false);
        $properties = CustomField::getAttributedProperties(get_class($this));
        foreach ($properties as $property) {
            $untypedValue = static::toString($this, $property);
            $property = $property->getName();
            update_post_meta($this->ID, $property, $untypedValue);
        }
        return $this->ID;
    }

    public function update(): void
    {
        wp_update_post($this);
        $properties = CustomField::getAttributedProperties(get_class($this));
        foreach ($properties as $property) {
            $untypedValue = static::toString($this, $property);
            $property = $property->getName();
            update_post_meta($this->ID, $property, $untypedValue);
        }
    }

    public function delete(bool $force_delete = false): bool
    {
        if ($force_delete) {
            $result = wp_delete_post($this->ID, force_delete: $force_delete);
        } else {
            $result = wp_trash_post($this->ID);
        }
        if (!$result) {
            return false;
        }
        return true;
    }
}