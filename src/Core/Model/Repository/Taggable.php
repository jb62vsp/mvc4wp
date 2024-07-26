<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Attribute\Entry;
use Mvc4Wp\Core\Model\TagEntity;

trait Taggable
{
    /**
     * @param string<class-string> $class
     * @return array<TagEntity>
     */
    public function getTags(string $class = TagEntity::class): array
    {
        return $this->tags = $class::find()->byPostID($this->ID)->build()->list();
    }

    /**
     * @param string $slug tag slug.
     * @param string<class-string> $class
     */
    public function hasTagBySlug(string $slug, string $class = TagEntity::class): bool
    {
        $tags = $class::find()->byPostID($this->ID)->bySlug($slug)->build()->list();
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