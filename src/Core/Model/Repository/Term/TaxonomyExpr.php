<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use Mvc4Wp\Core\Model\Repository\Expr;

class TaxonomyExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        if (count($contexts) === 1) {
            $query['taxonomy'] = $contexts[0];
        } else {
            $query['taxonomy'] = $contexts;
        }
        return $query;
    }
}