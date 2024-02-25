<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\Author\AuthorQuerable;
use Mvc4Wp\Core\Model\Repository\CustomField\CustomFieldQuerable;
use Mvc4Wp\Core\Model\Repository\Order\PostOrderQuerable;
use Mvc4Wp\Core\Model\Repository\Post\PostQuerable;
use Mvc4Wp\Core\Model\Repository\PostReturnFields\PostReturnFieldsQuerable;
use Mvc4Wp\Core\Model\Repository\PostSearch\PostSearchQuerable;
use Mvc4Wp\Core\Model\Repository\PostStatus\PostStatusQuerable;
use Mvc4Wp\Core\Model\Repository\PostType\PostTypeQuerable;

class PostQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    use
        Castable,
        AuthorQuerable,
        CustomFieldQuerable,
        PostOrderQuerable,
        PostQuerable,
        PostReturnFieldsQuerable,
        PostSearchQuerable,
        PostStatusQuerable,
        PostTypeQuerable;

    public function __construct(
        protected string $entity_class,
    ) {
    }

    public function build(): PostQueryExecutor
    {
        $new = $this->fetchOnlyID();
        $new = $new->asEntity($this->entity_class);
        $expressions = $new->getExpressions();
        $query = [];
        foreach ($expressions as $expr_class => $contexts) {
            $expr = new $expr_class();
            $query = $expr->toQuery($contexts, $query);
        }
        return new PostQueryExecutor($new->entity_class, $query);
    }
}