<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Author;

use Mvc4Wp\Core\Model\Repository\Expr;

class AuthorNotInExpr implements Expr
{
    public function toQuery(array $contexts): array
    {
        return ['author__not_in' => $contexts];
    }
}