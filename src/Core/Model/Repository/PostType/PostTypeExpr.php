<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostType;

use Mvc4Wp\Core\Model\Repository\Expr;

class PostTypeExpr implements Expr
{
    public function toQuery(array $contexts): array
    {
        if (empty($contexts)) {
            return [];
        } elseif (count($contexts) === 1) {
            return ['post_type' => $contexts[0]];
        } else {
            return ['post_type' => $contexts];
        }
    }
}