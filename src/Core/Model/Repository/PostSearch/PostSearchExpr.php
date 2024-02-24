<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostSearch;

use Mvc4Wp\Core\Model\Repository\Expr;

class PostSearchExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        $query['s'] = $contexts[0];
        return $query;
    }
}