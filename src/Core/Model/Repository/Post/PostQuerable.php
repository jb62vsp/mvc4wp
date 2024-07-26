<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Post;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#post-page-parameters
 */
trait PostQuerable
{
    /**
     * @param int $id Post ID.
     */
    public function byID(int $id): static
    {
        $new = clone $this;

        $new->setExpression(PostIDExpr::class, $id);

        return $new;
    }

    /**
     * @param string $slug Post slug.
     */
    public function bySlug(string $slug): static
    {
        $new = clone $this;

        $new->setExpression(PostNameExpr::class, $slug);

        return $new;       
    }

    /**
     * @param int $page_id Post page id.
     */
    public function byPageID(int $page_id): static
    {
        $new = clone $this;

        $new->setExpression(PostPageIDExpr::class, $page_id);

        return $new;       
    }

    /**
     * @param string $page_slug Post page slug.
     */
    public function byPageSlug(string $page_slug): static
    {
        $new = clone $this;

        $new->setExpression(PostPageNameExpr::class, $page_slug);

        return $new;       
    }
}