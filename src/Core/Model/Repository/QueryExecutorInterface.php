<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 */
interface QueryExecutorInterface
{
    /**
     * @return array<TModel>
     */
    public function get(): array;

    /**
     * @return TModel|null
     */
    public function getSingle(): Model|null;

    /**
     * @return TModel|null
     */
    public function byID(int $id): Model|null;

    /**
     * @return int
     */
    public function count(): int;
}