<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostStatus;

use Mvc4Wp\Core\Model\Repository\Expr;

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