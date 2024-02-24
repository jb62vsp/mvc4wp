<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

trait OrderQuerable
{
    /**
     * CAUTION - custom field only
     * @param string $field Custom field key.
     * @param string $order Toward.
     * @param string $type Custom field type.
     * Possible values are 'NUMERIC', 'BINARY', 'CHAR', 'DATE', 'DATETIME', 'DECIMAL', 'SIGNED', 'TIME', 'UNSIGNED'.
     * Default value is 'CHAR'.
     */
    public function orderBy(string $field, string $order = 'ASC', string $type = 'CHAR'): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [$field => [strtoupper($order), strtoupper($type)]]);

        return $new;
    }

    public function orderByID(string $order = 'ASC'): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::ID => [strtoupper($order), '']]);

        return $new;
    }

    public function orderByName(string $order = 'ASC'): static
    {
        $new = clone $this;

        $new->addExpression(OrderByExpr::class, [OrderByExpr::NAME => [strtoupper($order), '']]);

        return $new;
    }
}