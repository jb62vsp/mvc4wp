<?php declare(strict_types=1);
namespace System\Models\Repository;

use System\Models\Model;

trait QueryTrait
{
    abstract public function search(string $key, string $value, string $compare = '=', string $type = 'CHAR'): self;

    abstract public function order(string $order_by, string $order = 'ASC', string $type = 'CHAR'): self;

    /**
     * @return array<Model>
     */
    abstract public function get(): array;

    abstract public function getSingle(): ?Model;

    abstract public function byID(int $id): ?Model;

    abstract public function count(): int;
}