<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use Mvc4Wp\Core\Model\Repository\Expr;

class TermExcludeExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        if (count($contexts) === 1) {
            $query['exclude'] = $contexts[0];
        } else {
            $query['exclude'] = $contexts;
        }
        return $query;
    }
}