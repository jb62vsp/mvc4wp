<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Author;

use Mvc4Wp\Core\Model\Repository\Expr;

class AuthorNameExpr implements Expr
{
    public function toQuery(array $contexts): array
    {
        if (empty($contexts)) {
            return [];
        } else {
            return [['author_name' => $contexts[0]]];
        }
    }
}