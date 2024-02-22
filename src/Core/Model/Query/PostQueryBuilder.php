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
 * @extends AbstractQueryBuilder<TModel>
 */
class PostQueryBuilder extends AbstractQueryBuilder
{
    protected array $expressions = [];

    public function build(): QueryExecutorInterface
    {
        return new PostQueryExecutor([]); // TODO:
    }

    public function asModel(string ...$classes): static
    {
        $new = clone $this;

        $post_types = [];
        foreach ($classes as $class) {
            array_push($post_types, PostType::getName($class));
        }
        $new->addExpression(PostTypeExpr::class, $post_types);

        return $new;
    }

    public function byAuthor(int $author): static
    {
        $new = clone $this;

        $new->setExpression(AuthorExpr::class, $author);

        return $new;
    }

    public function byAuthorName(string $authorName): static
    {
        $new = clone $this;

        $new->setExpression(AuthorNameExpr::class, $authorName);

        return $new;
    }

    public function byAuthorIn(int ...$authors): static
    {
        $new = clone $this;

        $new->addExpression(AuthorInExpr::class, $authors);

        return $new;
    }

    public function byAuthorNotIn(int ...$authors): static
    {
        $new = clone $this;

        $new->addExpression(AuthorNotInExpr::class, $authors);

        return $new;
    }
}