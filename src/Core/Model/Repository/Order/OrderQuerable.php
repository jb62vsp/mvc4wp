<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Model\Repository\OrderInQuery;
use Mvc4Wp\Core\Model\Repository\TypeInQuery;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters
 */
trait OrderQuerable
{
    /**
     * CAUTION - custom field only
     * @param string $field Custom field key.
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     * @param TypeInQuery $type Custom field type.
     * Default value is 'CHAR'.
     */
    public function orderBy(string $field, OrderInQuery $order = OrderInQuery::ASC, TypeInQuery $type = TypeInQuery::CHAR): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [$field => [$order->value, $type->value]]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByID(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::ID => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByName(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::NAME => [$order->value, '']]);

        return $new;
    }
}