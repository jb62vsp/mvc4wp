<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Cast;
use Mvc4Wp\Core\Library\Wp;
use Mvc4Wp\Core\Model\Repository\PostQuery;
use Mvc4Wp\Core\Model\Repository\QueryInterface;

/**
 * @template TModel of PostModel
 * @extends PostEntity<TModel>
 */
#[PostType(name: 'post')]
class PostModel extends PostEntity
{
    use Cast;

    public function __construct()
    {
        $this->post_type = PostType::getName(static::class);
    }

    /**
     * @return PostQuery<TModel>
     */
    public static function find(): QueryInterface
    {
        /** @var PostQuery<TModel> */
        $result = new PostQuery(static::class);
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
            $untypedValue = static::reverseProperty($this, $property);
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
            $untypedValue = static::reverseProperty($this, $property);
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