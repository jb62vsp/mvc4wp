<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Author;

use Mvc4Wp\Core\Model\Repository\Expr;

class AuthorInExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        $query['author__in'] = $contexts;
        return $query;
    }
}