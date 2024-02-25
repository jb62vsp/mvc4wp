<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostPaginate;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use Mvc4Wp\Core\Model\Repository\Expr;

class PostPaginateExpr implements Expr
{
    public function toQuery(array $contexts, array $query): array
    {
        if (empty($contexts)) {
            return $query;
        }

        [$count, $page] = $this->tuplize($contexts[0]);

        $query['posts_per_page'] = $count;
        if ($count >= 0) {
            $query['paged'] = $page;
        }
        return $query;
    }

    /**
     * @return list<int, int>
     */
    protected function tuplize(array $context): array
    {
        [$count, $page] = $context;

        if (is_null($count)) {
            throw new QueryBuildViolationException('count'); // TODO:
        }
        if (is_null($page)) {
            throw new QueryBuildViolationException('page'); // TODO:
        }

        return $context;
    }
}