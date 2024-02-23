<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\PostStatus;

use Mvc4Wp\Core\Model\Model;
use Mvc4Wp\Core\Model\Query\Expr;

/**
 * @template TModel of Model
 * @implements Expr<TModel>
 */
class PostStatusExpr implements Expr
{
    public function toQuery(array $contexts): array
    {
        if (empty($contexts)) {
            return [];
        } elseif (count($contexts) === 1) {
            return ['post_status' => $contexts[0]];
        } else {
            return ['post_status' => $contexts];
        }
    }
}