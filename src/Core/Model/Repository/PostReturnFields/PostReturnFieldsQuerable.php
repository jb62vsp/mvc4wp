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
    public function fetchAll(): static
    {
        $new = clone $this;

        $new->setExpression(PostReturnFieldsExpr::class, 'all');

        return $new;
    }

    /**
     * Return an array of post IDs.
     */
    public function fetchOnlyID(): static
    {
        $new = clone $this;

        $new->setExpression(PostReturnFieldsExpr::class, 'ids');

        return $new;
    }

    /**
     * Return an array of stdClass objects with ID and post_parent properties.
     */
    public function parent(): static
    {
        $new = clone $this;

        $new->setExpression(PostReturnFieldsExpr::class, 'id=>parent');

        return $new;
    }
}