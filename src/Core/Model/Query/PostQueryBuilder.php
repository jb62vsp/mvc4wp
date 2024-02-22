<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query;

use Mvc4Wp\Core\Model\PostModel;
use Mvc4Wp\Core\Model\PostType;
use Mvc4Wp\Core\Model\Query\Author\AuthorExpr;
use Mvc4Wp\Core\Model\Query\Author\AuthorInExpr;
use Mvc4Wp\Core\Model\Query\Author\AuthorNameExpr;
use Mvc4Wp\Core\Model\Query\Author\AuthorNotInExpr;
use Mvc4Wp\Core\Model\Query\PostType\PostTypeExpr;

/**
 * @template TModel of PostModel
 * @implements QueryBuilderInterface<TModel>
 */
class PostQueryBuilder
{
    /**
     * @var array<Expr> $expressions
     */
    protected array $queries = [];

    public function __construct()
    {
    }

    public function getQueries(): array
    {
        return $this->queries;
    }

    public function asModel(string ...$classes): static
    {
        $new = clone $this;

        $post_types = [];
        foreach ($classes as $class) {
            array_push($post_types, PostType::getName($class));
        }
        array_push($new->queries, (new PostTypeExpr(...$post_types))->toQuery());

        return $new;
    }

    public function byAuthor(int $author): static
    {
        $new = clone $this;

        array_push($new->queries, new AuthorExpr($author));

        return $new;
    }

    public function byAuthorName(string $authorName): static
    {
        $new = clone $this;

        array_push($new->queries, new AuthorNameExpr($authorName));

        return $new;
    }

    public function byAuthorIn(int ...$authors): static
    {
        $new = clone $this;

        array_push($new->queries, new AuthorInExpr(...$authors));

        return $new;
    }

    public function byAuthorNotIn(int ...$authors): static
    {
        $new = clone $this;

        array_push($new->queries, new AuthorNotInExpr(...$authors));

        return $new;
    }
}