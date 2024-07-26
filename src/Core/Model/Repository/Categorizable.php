<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Attribute\Entry;
use Mvc4Wp\Core\Model\CategoryEntity;

trait Categorizable
{
    /**
     * @param string<class-string> $class
     * @return array<CategoryEntity>
     */
    public function getCategories(string $class = CategoryEntity::class): array
    {
        return $this->categories = $class::find()->byPostID($this->ID)->build()->list();
    }

    /**
     * @param string $slug category slug.
     * @param string<class-string> $class
     */
    public function hasCategoryBySlug(string $slug, string $class = CategoryEntity::class): bool
    {
        $categories = $class::find()->byPostID($this->ID)->bySlug($slug)->build()->list();
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

    /**
     * @param string<class-string> $class
     */
    public function removeCategories(string $class = CategoryEntity::class): void
    {
        wp_delete_object_term_relationships($this->ID, Entry::getClassAttribute($class)->name);
    }
}