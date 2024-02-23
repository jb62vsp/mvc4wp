<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Model;

interface QueryExecutorInterface
{
    public function get(): array;

    public function getSingle(): Model|null;

    public function byID(int $id): Model|null;

    public function count(): int;
}