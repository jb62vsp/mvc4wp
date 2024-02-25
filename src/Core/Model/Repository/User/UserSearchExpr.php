<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\User;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use Mvc4Wp\Core\Model\Repository\Expr;

class UserSearchExpr implements Expr
{
    public const ID = 'ID';

    public const USER_LOGIN = 'user_login';

    public const USER_NICENAME = 'user_nicename';

    public const USER_EMAIL = 'user_email';

    public const USER_URL = 'user_url';

    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        [$search, $search_columns] = $this->tuplize($contexts);
        $query['search'] = $search;
        $query['search_columns'] = $search_columns;
        return $query;
    }

    /**
     * @return list<string, array>
     */
    protected function tuplize(array $context): array
    {
        [$search, $search_columns] = $context;

        if (is_null($search_columns)) {
            throw new QueryBuildViolationException("search_columns"); // TODO:
        }

        return $context;
    }
}