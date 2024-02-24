<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostSearch;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#search-parameters
 */

trait PostSearchQuerable
{
    /**
     * @param string $search Search keyword.
     */
    public function search(string $search): static
    {
        $new = clone $this;

        $new->setExpression(PostSearchExpr::class, $search);

        return $new;
    }
}