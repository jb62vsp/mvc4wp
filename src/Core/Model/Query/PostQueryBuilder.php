<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query;

use Mvc4Wp\Core\Model\PostType;
use Mvc4Wp\Core\Model\Query\Author\AuthorExpr;
use Mvc4Wp\Core\Model\Query\Author\AuthorInExpr;
use Mvc4Wp\Core\Model\Query\Author\AuthorNameExpr;
use Mvc4Wp\Core\Model\Query\Author\AuthorNotInExpr;
use Mvc4Wp\Core\Model\Query\PostType\PostTypeExpr;

class PostQuery
{
    /**
     * @var array<Expr> $expressions
     */
    protected array $queries = [];

    public function __construct()
    {
    }

    public function postType(string ...$classes): static
    {
        $new = clone $this;

        $post_types = [];
        foreach ($classes as $class) {
            array_push($post_types, PostType::getName($class));
        }
        $this->queries['post_type'] = new PostTypeExpr(...$post_types);

        return $new;
    }

    public function author(int $author): static
    {
        $new = clone $this;

        $this->queries['author'] = new AuthorExpr($author);

        return $new;
    }

    public function authorIn(int ...$authors): static
    {
        $new = clone $this;

        $this->queries['author'] = new AuthorInExpr(...$authors);

        return $new;
    }

    public function authorNotIn(int ...$authors): static
    {
        $new = clone $this;

        $this->queries['author'] = new AuthorNotInExpr(...$authors);

        return $new;
    }

    public function authorName(string $authorName): static
    {
        $new = clone $this;

        $this->queries['author'] = new AuthorNameExpr($authorName);

        return $new;
    }
}