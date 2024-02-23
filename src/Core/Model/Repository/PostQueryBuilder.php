<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\PostModel;
use Mvc4Wp\Core\Model\Repository\Author\AuthorQuerable;
use Mvc4Wp\Core\Model\Repository\CustomField\CustomFieldQuerable;
use Mvc4Wp\Core\Model\Repository\PostSearch\PostSearchQuerable;
use Mvc4Wp\Core\Model\Repository\PostStatus\PostStatusQuerable;
use Mvc4Wp\Core\Model\Repository\PostType\PostTypeQuerable;
use Mvc4Wp\Core\Model\Repository\ReturnFields\ReturnFieldsQuerable;

/**
 * @template TModel of PostModel
 * @extends AbstractQueryBuilder<TModel>
 * @implements QueryBuilderInterface<TModel>
 */
class PostQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * @use AuthorQuerable<TModel>
     * @use CustomFieldQuerable<TModel>
     * @use PostSearchQuerable<TModel>
     * @use PostStatusQuerable<TModel>
     * @use PostTypeQuerable<TModel>
     * @use ReturnFieldsQuerable<TModel>
     */
    use Castable, AuthorQuerable, CustomFieldQuerable, PostSearchQuerable, PostStatusQuerable, PostTypeQuerable, ReturnFieldsQuerable;

    public function __construct(
        protected string $entity_class,
    ) {
    }
    public function build(): QueryExecutorInterface
    {
        $new = $this->fetchOnlyID();
        $expressions = $new->getExpressions();
        $queries = [];
        foreach ($expressions as $expr_class => $contexts) {
            /** @var Expr<TModel> $expr */
            $expr = new $expr_class();
            $queries = array_merge($queries, $expr->toQuery($contexts));
        }
        return new PostQueryExecutor($new->entity_class, $queries);
    }
}