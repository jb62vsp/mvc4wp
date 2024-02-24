<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Raw;

use Generator;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\Expr;

class RawExpr implements Expr
{
    use Castable;

    public function toQuery(array $contexts): array
    {
        return $contexts;
    }
}