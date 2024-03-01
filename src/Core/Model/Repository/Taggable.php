<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Attribute\Entry;
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

    /**
     * @param string $slug tag slug.
     */
    public function hasTagBySlug(string $slug): bool
    {
        $tags = TagEntity::find()->byPostID($this->ID)->bySlug($slug)->build()->list();
        return !empty($tags);
    }

    /**
     * @param TagEntity $tag
     */
    public function addTag(TagEntity $tag): void
    {
        wp_set_object_terms($this->ID, $tag->term_id, $tag->taxonomy, true);
    }

    /**
     * @param array<TagEntity>
     */
    public function addTags(array $tags): void
    {
        foreach ($tags as $tag) {
            $this->addTag($tag);
        }
    }

    public function setTag(TagEntity $tag): void
    {
        wp_set_object_terms($this->ID, $tag->term_id, $tag->taxonomy, false);
    }

    /**
     * @param array<TagEntity>
     */
    public function setTags(array $tags): void
    {
        for ($i = 0, $il = count($tags); $i < $il; $i++) {
            if ($i === 0) {
                $this->setTag($tags[$i]);
            } else {
                $this->addTag($tags[$i]);
            }
        }
    }

    public function removeTags(): void
    {
        wp_delete_object_term_relationships($this->ID, Entry::getClassAttribute(TagEntity::class)->name);
    }
}