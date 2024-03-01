<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Model\Repository\OrderInQuery;

trait PostOrderQuerable
{
    use OrderQuerable;

    public function noOrder(): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::NONE => [OrderInQuery::ASC->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByAuthor(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::AUTHOR => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByTitle(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::TITLE => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByType(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::TYPE => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByDate(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::DATE => [$order->value, '']]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByModified(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::MODIFIED => [$order->value, '']]);

        return $new;
    }
}