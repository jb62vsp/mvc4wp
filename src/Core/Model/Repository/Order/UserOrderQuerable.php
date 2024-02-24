<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Model\Repository\OrderInQuery;
use Mvc4Wp\Core\Model\Repository\TypeInQuery;

trait UserOrderQuerable
{
    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByDisplayName(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::DISPLAY_NAME => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByLogin(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::LOGIN => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByNicename(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::NICENAME => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByEmail(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::EMAIL => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByUrl(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::URL => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByRegistered(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::REGISTERED => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByPostCount(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::POST_COUNT => [$order->value, '']]);

        return $new;
    }
}