<?php declare(strict_types=1);
namespace System\Models\Repository;

interface RepositoryInterface
{
    public static function find(): QueryInterface;
    
    public function register(): int;

    public function update(): void;

    public function delete(bool $force_delete = false): bool;
}