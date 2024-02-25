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

        $new->setExpression(PostPageIDExpr::class, $id);

        return $new;
    }
}