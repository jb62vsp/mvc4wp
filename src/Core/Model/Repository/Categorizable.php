<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Attribute\Entry;
use Mvc4Wp\Core\Model\CategoryEntity;

trait Categorizable
{
    /**
     * @var array<CategoryEntity>
     */
    protected array $categories;

    /**
     * @return array<CategoryEntity>
     */
    public function getCategories(): array
    {
        if (!isset($this->categories)) {
            $this->categories = CategoryEntity::find()->byPostID($this->ID)->build()->list();
        }

        return $this->categories;
    }

    /**
     * @param string $slug category slug.
     */
    public function hasCategoryBySlug(string $slug): bool
    {
        $categories = CategoryEntity::find()->byPostID($this->ID)->bySlug($slug)->build()->list();
        return !empty($categories);
    }

    /**
     * @param CategoryEntity $category
     */
    public function addCategory(CategoryEntity $category): void
    {
        wp_set_object_terms($this->ID, $category->term_id, $category->taxonomy, true);
    }

    /**
     * @param array<CategoryEntity>
     */
    public function addCategories(array $categories): void
    {
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    public function setCategory(CategoryEntity $category): void
    {
        wp_set_object_terms($this->ID, $category->term_id, $category->taxonomy, false);
    }

    /**
     * @param array<CategoryEntity>
     */
    public function setCategories(array $categories): void
    {
        for ($i = 0, $il = count($categories); $i < $il; $i++) {
            if ($i === 0) {
                $this->setCategory($categories[$i]);
            } else {
                $this->addCategory($categories[$i]);
            }
        }
    }

    public function removeCategories(): void
    {
        wp_delete_object_term_relationships($this->ID, Entry::getClassAttribute(CategoryEntity::class)->name);
    }
}