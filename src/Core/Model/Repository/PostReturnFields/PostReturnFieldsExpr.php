<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostReturnFields;

use Mvc4Wp\Core\Model\Repository\Expr;

class PostReturnFieldsExpr implements Expr
{
    public function toQuery(array $contexts): array
    {
        if (empty($contexts)) {
            return [];
        } else {
            return ['fields' => $contexts[0]];
        }
    }
}