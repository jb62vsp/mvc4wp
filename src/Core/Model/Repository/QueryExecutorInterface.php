<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Entity;

interface QueryExecutorInterface
{
    public function get(): array;

    public function getSingle(): Entity|null;

    public function byID(int $id): Entity|null;

    public function count(): int;
}