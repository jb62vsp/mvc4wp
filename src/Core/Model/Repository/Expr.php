<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

interface Expr
{
   public function toQuery(array $contexts, array $query): array;
}