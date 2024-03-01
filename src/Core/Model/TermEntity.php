<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Model\Attribute\Field;

abstract class TermEntity extends Entity
{
    #[Field]
    public readonly int $term_id;

    #[Field]
    public string $name;

    #[Field]
    public string $slug;

    #[Field]
    public int $term_group;

    #[Field]
    public int $term_taxonomy_id;

    #[Field]
    public string $taxonomy;

    #[Field]
    public string $description;

    #[Field]
    public int $count;

    public function isLoaded(): bool
    {
        return isset($this->term_id);
    }

    private function setValue(string $property, mixed $value): void
    {
        if ($property === 'term_id') {
            if (!$this->isLoaded()) {
                $this->{$property} = $value;
            }
        } else {
            $this->{$property} = $value;
        }
    }
}