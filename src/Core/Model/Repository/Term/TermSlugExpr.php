<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use Mvc4Wp\Core\Model\Repository\Expr;

class TermSlugExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        $query['slug'] = strval($contexts[0]);

        return $query;
    }
}