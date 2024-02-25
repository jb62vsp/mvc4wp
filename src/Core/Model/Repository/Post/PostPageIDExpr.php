<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Post;

use Mvc4Wp\Core\Model\Repository\Expr;

class PostPageIDExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        $query['page_id'] = $contexts[0];
        return $query;
    }
}