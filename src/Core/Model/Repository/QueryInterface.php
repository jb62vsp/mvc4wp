<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 */
interface QueryInterface
{
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