<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Search;

use Mvc4Wp\Core\Model\Model;
use Mvc4Wp\Core\Model\Query\Expr;

/**
 * @template TModel of Model
 * @implements Expr<TModel>
 */
class SearchExpr implements Expr
{
    public function toQuery(array $context): array
    {
        if (empty($context)) {
            return [];
        } else {
            return ['s' => $context[0]];
        }
    }
}