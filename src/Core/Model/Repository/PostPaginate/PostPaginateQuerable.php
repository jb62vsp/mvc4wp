<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostPaginate;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#pagination-parameters
 */
trait PostPaginateQuerable
{
    /**
     * get all posts.
     */
    public function all(): static
    {
        $new = clone $this;

        $new->setExpression(PostPaginateExpr::class, [[-1, -1]]);

        return $new;
    }

    /**
     * get N posts.
     * @param int $count number of posts.
     * @param int $page number of page.
     */
    public function limitOf(int $count, int $page): static
    {
        $new = clone $this;

        $new->setExpression(PostPaginateExpr::class, [[$count, $page]]);

        return $new;
    }
}