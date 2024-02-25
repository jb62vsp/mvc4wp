<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostStatus;

use Mvc4Wp\Core\Model\Repository\Expr;

class PostStatusExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        if (count($contexts) === 1) {
            $query['post_status'] = $contexts[0];
        } else {
            $query['post_status'] = $contexts;
        }
        return $query;
    }
}