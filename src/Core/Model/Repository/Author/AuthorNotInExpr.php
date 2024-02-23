<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Author;

use Mvc4Wp\Core\Model\Model;
use Mvc4Wp\Core\Model\Repository\Expr;

/**
 * @template TModel of Model
 * @implements Expr<TModel>
 */
class AuthorNotInExpr implements Expr
{
    public function toQuery(array $contexts): array
    {
        return ['author__not_in' => $contexts];
    }
}