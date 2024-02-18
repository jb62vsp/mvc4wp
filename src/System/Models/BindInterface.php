<?php declare(strict_types=1);
namespace System\Models;

interface BindInterface
{
    public function getID(): int;

    public function idBinded(): bool;

    public function bind(object|array $data, bool $validation = true): array;
}