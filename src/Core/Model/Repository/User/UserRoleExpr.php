<?php

declare(strict_types=1);

namespace Mvc4Wp\Core\Model\Repository\User;

use Mvc4Wp\Core\Model\Repository\Expr;

class UserRoleExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        $query['role'] = $contexts[0];
        return $query;
    }
}
