<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\Entry;
use Mvc4Wp\Core\Model\Attribute\Field;
use Mvc4Wp\Core\Model\Repository\TermQueryBuilder;

#[Entry(name: 'post_tag')]
class TagEntity extends TermEntity
{
    use Castable;

    public static function find(): TermQueryBuilder
    {
        $result = new TermQueryBuilder(static::class);
        return $result;
    }

    /**
     * @param string $slug
     * @return static|null
     */
    public static function findBySlug(string $slug): static|null
    {
        return static::find()
            ->bySlug($slug)
            ->showEmpty()
            ->build()
            ->single()
        ;
    }

    public function register(bool $publish = true): int
    {
        $term_ids = wp_insert_term($this->name, $this->taxonomy, [
            'description' => $this->description,
            'parent' => 0,
            'slug' => $this->slug,
        ]);
        $this->bind($term_ids);
        $properties = CustomField::getAttributedProperties(get_class($this));
        foreach ($properties as $property) {
            $untypedValue = static::toString($this, $property);
            $property = $property->getName();
            update_term_meta($this->term_id, $property, $untypedValue);
        }
        return $this->term_id;
    }

    public function update(): void
    {
        wp_update_term($this->term_id, $this->taxonomy, [
            'description' => $this->description,
            'parent' => 0,
            'slug' => $this->slug,
        ]);
        $properties = CustomField::getAttributedProperties(get_class($this));
        foreach ($properties as $property) {
            $untypedValue = static::toString($this, $property);
            $property = $property->getName();
            update_term_meta($this->term_id, $property, $untypedValue);
        }
    }

    public function delete(bool $force_delete = false): bool
    {
        $result = wp_delete_term($this->term_id, $this->taxonomy);
        return $result;
    }
}