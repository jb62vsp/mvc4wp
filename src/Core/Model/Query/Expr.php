<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 */
interface Expr
{
   public function toQuery(array $context): array;
}