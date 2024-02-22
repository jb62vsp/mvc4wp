<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 * @implements QueryExecutorInterface<TModel>
 */
class PostQueryExecutor implements QueryExecutorInterface
{
    public function __construct(
        protected array $query
    ) {
    }
    
    /**
     * @return array<TModel>
     */
    public function get(): array
    {
        return []; // TODO
    }

    /**
     * @return TModel|null
     */
    public function getSingle(): Model|null
    {
        return null;
    }

    /**
     * @return TModel|null
     */
    public function byID(int $id): Model|null
    {
        return null;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return 0;
    }
}