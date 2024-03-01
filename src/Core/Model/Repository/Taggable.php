<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\TagEntity;

trait Taggable
{
    /**
     * @var array<TagEntity>
     */
    protected array $tags;

    /**
     * @return array<TagEntity>
     */
    public function getTags(): array
    {
        if (!isset($this->tags)) {
            $this->tags = TagEntity::find()->byPostID($this->ID)->build()->list();
        }

        return $this->tags;
    }
}