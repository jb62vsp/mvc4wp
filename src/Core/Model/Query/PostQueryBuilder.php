<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\PostModel;
use Mvc4Wp\Core\Model\Query\Author\AuthorQuerable;
use Mvc4Wp\Core\Model\Query\PostType\PostTypeQuerable;

/**
 * @template TModel of PostModel
 * @extends AbstractQueryBuilder<TModel>
 * @implements QueryBuilderInterface<TModel>
 */
class PostQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    /**
     * @use AuthorQuerable<TModel>
     * @use PostTypeQuerable<TModel>
     */
    use Castable, AuthorQuerable, PostTypeQuerable;

    public function toQuery(): QueryExecutorInterface
    {
        return new PostQueryExecutor([]); // TODO:
    }
}