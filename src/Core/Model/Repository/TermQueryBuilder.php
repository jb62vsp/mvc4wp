<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\Order\TermOrderQuerable;
use Mvc4Wp\Core\Model\Repository\Raw\RawQuerable;
use Mvc4Wp\Core\Model\Repository\Taxonomy\TaxonomyQuerable;

class TermQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    use Castable,
        RawQuerable,
        TaxonomyQuerable,
        TermOrderQuerable;

    public function __construct(
        protected string $entity_class,
    ) {
    }

    public function build(): TermQueryExecutor
    {
        $new = clone $this;
        $new = $new->asEntity($this->entity_class);
        $expressions = $new->getExpressions();
        $query = [];
        foreach ($expressions as $expr_class => $contexts) {
            $expr = new $expr_class();
            $query = $expr->toQuery($contexts, $query);
        }
        return new TermQueryExecutor($this->entity_class, $query);
    }
}