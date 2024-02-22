<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Author;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 */

trait AuthorQuerable
{
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