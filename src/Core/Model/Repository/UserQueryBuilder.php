<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\Order\UserOrderQuerable;

class UserQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    use
        Castable,
        UserOrderQuerable;

    public function __construct(
        protected string $entity_class,
    ) {
    }

    public function build(): UserQueryExecutor
    {
        $new = clone $this;
        $expressions = $new->getExpressions();
        $query = [];
        foreach ($expressions as $expr_class => $contexts) {
            $expr = new $expr_class();
            $query = $expr->toQuery($contexts, $query);
        }
        return new UserQueryExecutor($new->entity_class, $query);
    }
}