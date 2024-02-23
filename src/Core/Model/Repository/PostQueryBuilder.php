<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\Author\AuthorQuerable;
use Mvc4Wp\Core\Model\Repository\CustomField\CustomFieldQuerable;
use Mvc4Wp\Core\Model\Repository\PostReturnFields\PostReturnFieldsQuerable;
use Mvc4Wp\Core\Model\Repository\PostSearch\PostSearchQuerable;
use Mvc4Wp\Core\Model\Repository\PostStatus\PostStatusQuerable;
use Mvc4Wp\Core\Model\Repository\PostType\PostTypeQuerable;

class PostQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    use Castable, AuthorQuerable, CustomFieldQuerable, PostReturnFieldsQuerable, PostSearchQuerable, PostStatusQuerable, PostTypeQuerable;

    public function __construct(
        protected string $entity_class,
    ) {
    }

    public function build(): PostQueryExecutor
    {
        $new = $this->fetchOnlyID();
        $expressions = $new->getExpressions();
        $queries = [];
        foreach ($expressions as $expr_class => $contexts) {
            $expr = new $expr_class();
            $queries = array_merge($queries, $expr->toQuery($contexts));
        }
        return new PostQueryExecutor($new->entity_class, $queries);
    }
}