<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Search;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 * @see https://developer.wordpress.org/reference/classes/wp_query/#search-parameters
 */

trait SearchQuerable
{
    /**
     * @param string $search Search keyword.
     */
    public function search(string $search): static
    {
        $new = clone $this;

        $new->setExpression(SearchExpr::class, $search);

        return $new;
    }
}