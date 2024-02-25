<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Entity;

interface QueryExecutorInterface
{
    public function list(): array;

    public function single(): Entity|null;

    public function count(): int;
}