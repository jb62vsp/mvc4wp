<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query;

interface Expr
{
   public function toQuery(): array;
}