<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Model\Repository\OrderInQuery;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_term_query/__construct/#parameters
 */
trait TermOrderQuerable
{
    /**
     * CAUTION - custom field only
     * @param string $field Custom field key.
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderBy(string $field, OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->addExpression(TermOrderByExpr::class, [$field => $order->value]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByName(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->setExpression(TermOrderByExpr::class, [TermOrderByExpr::NAME => $order->value]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderBySlug(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->setExpression(TermOrderByExpr::class, [TermOrderByExpr::SLUG => $order->value]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByTermGroup(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->setExpression(TermOrderByExpr::class, [TermOrderByExpr::TERM_GROUP => $order->value]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByTermID(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->setExpression(TermOrderByExpr::class, [TermOrderByExpr::TERM_ID => $order->value]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByID(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->setExpression(TermOrderByExpr::class, [TermOrderByExpr::ID => $order->value]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByDescription(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->setExpression(TermOrderByExpr::class, [TermOrderByExpr::DESCRIPTION => $order->value]);

        return $new;
    }

    /**
     * @param OrderInQuery $order Order.
     * Default value is 'ASC'.
     */
    public function orderByCount(OrderInQuery $order = OrderInQuery::ASC): static
    {
        $new = clone $this;

        $new->setExpression(TermOrderByExpr::class, [TermOrderByExpr::COUNT => $order->value]);

        return $new;
    }
}