<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model\Repository;

use Mvc4Wp\System\Model\Model;

/**
 * @template TModel of Model
 */
interface QueryInterface
{
    /**
     * @return QueryInterface<TModel>
     */
    public function search(string $key, string $value, string $compare = '=', string $type = 'CHAR'): QueryInterface;

    /**
     * @return QueryInterface<TModel>
     */
    public function order(string $order_by, string $order = 'ASC', string $type = 'CHAR'): QueryInterface;

    /**
     * @return array<TModel>
     */
    public function get(): array;

    /**
     * @return TModel|null
     */
    public function getSingle(): ?Model;

    /**
     * @return TModel|null
     */
    public function byID(int $id): ?Model;

    /**
     * @return int
     */
    public function count(): int;
}