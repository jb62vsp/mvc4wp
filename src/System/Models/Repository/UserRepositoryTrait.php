<?php declare(strict_types=1);
namespace System\Models\Repository;

trait UserRepositoryTrait
{
    public static function find(): QueryInterface
    {
        return new UserQuery(static::class);
    }

    public function register(): int
    {
        return -1; // TODO:
    }

    public function update(): void
    {
        // TODO:
    }

    public function delete(bool $force_delete = false): bool
    {
        return false;
    }
}