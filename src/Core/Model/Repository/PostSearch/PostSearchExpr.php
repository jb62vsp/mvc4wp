<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostSearch;

use Mvc4Wp\Core\Model\Repository\Expr;

class PostSearchExpr implements Expr
{
    public function toQuery(array $contexts): array
    {
        if (empty($contexts)) {
            return [];
        } else {
            return [['s' => $contexts[0]]];
        }
    }
}