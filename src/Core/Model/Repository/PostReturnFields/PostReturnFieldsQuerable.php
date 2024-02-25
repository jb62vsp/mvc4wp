<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostReturnFields;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#return-fields-parameter
 */

trait PostReturnFieldsQuerable
{
    /**
     * Return all fields.
     */
    protected function fetchAll(): static
    {
        $new = clone $this;

        $new->setExpression(PostReturnFieldsExpr::class, 'all');

        return $new;
    }

    /**
     * Return an array of post IDs.
     */
    protected function fetchOnlyID(): static
    {
        $new = clone $this;

        $new->setExpression(PostReturnFieldsExpr::class, 'ids');

        return $new;
    }

    /**
     * Return an array of stdClass objects with ID and post_parent properties.
     */
    protected function parent(): static
    {
        $new = clone $this;

        $new->setExpression(PostReturnFieldsExpr::class, 'id=>parent');

        return $new;
    }
}