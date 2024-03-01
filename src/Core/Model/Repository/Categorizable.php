<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

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
}