<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

interface RepositoryInterface
{
    public static function find(): QueryBuilderInterface;

    public function register(): int;

    public function update(): void;

    public function delete(bool $force_delete = false): bool;
}