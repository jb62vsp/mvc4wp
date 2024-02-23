<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;

class UserQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    use Castable;

    public function __construct(
        protected string $entity_class,
    ) {
    }

    public function build(): UserQueryExecutor
    {
        $new = clone $this;
        $expressions = $new->getExpressions();
        $queries = [];
        foreach ($expressions as $expr_class => $contexts) {
            $expr = new $expr_class();
            $queries = array_merge($queries, $expr->toQuery($contexts));
        }
        return new UserQueryExecutor($new->entity_class, $queries);
    }
}