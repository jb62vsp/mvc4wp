<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Author;

use Mvc4Wp\Core\Model\Repository\Expr;

class AuthorInExpr implements Expr
{
    public function toQuery(array $contexts): array
    {
        return ['author__in' => $contexts];
    }
}