<?php declare(strict_types=1);
namespace System\Models\Repository;

use System\Models\Model;

interface QueryInterface
{
    public function search(string $key, string $value, string $compare = '=', string $type = 'CHAR'): self;

    public function order(string $order_by, string $order = 'ASC', string $type = 'CHAR'): self;

    /**
     * @return array<Model>
     */
    public function get(): array;

    public function getSingle(): ?Model;

    public function byID(int $id): ?Model;

    public function count(): int;
}