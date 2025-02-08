<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use Mvc4Wp\Core\Model\Repository\Expr;

class TermChildOfExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        if (count($contexts) === 1) {
            $query['child_of'] = $contexts[0];
        } else {
            $query['child_of'] = $contexts;
        }
        return $query;
    }
}