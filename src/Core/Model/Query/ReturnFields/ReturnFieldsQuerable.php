<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\ReturnFields;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 * @see https://developer.wordpress.org/reference/classes/wp_query/#return-fields-parameter
 */

trait ReturnFieldsQuerable
{
    /**
     * Return all fields.
     */
    public function fetchAll(): static
    {
        $new = clone $this;

        $new->setExpression(ReturnFieldsExpr::class, 'all');

        return $new;
    }

    /**
     * Return an array of post IDs.
     */
    public function fetchOnlyID(): static
    {
        $new = clone $this;

        $new->setExpression(ReturnFieldsExpr::class, 'ids');

        return $new;
    }

    /**
     * Return an array of stdClass objects with ID and post_parent properties.
     */
    public function parent(): static
    {
        $new = clone $this;

        $new->setExpression(ReturnFieldsExpr::class, 'id=>parent');

        return $new;
    }
}