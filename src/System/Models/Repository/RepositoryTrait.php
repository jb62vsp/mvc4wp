<?php declare(strict_types=1);
namespace System\Models\Repository;

trait RepositoryTrait
{
    abstract public function register(): int;

    abstract public function update(): void;

    abstract public function delete(bool $force_delete = false): bool;
}