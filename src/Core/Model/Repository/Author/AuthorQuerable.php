<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Author;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#author-parameters
 */
trait AuthorQuerable
{
    /**
     * @param int $author use author id.
     */
    public function byAuthor(int $author): static
    {
        $new = clone $this;

        $new->setExpression(AuthorExpr::class, $author);

        return $new;
    }

    /**
     * @param string $authorName use `user_nicename` – NOT name.
     */
    public function byAuthorName(string $authorName): static
    {
        $new = clone $this;

        $new->setExpression(AuthorNameExpr::class, $authorName);

        return $new;
    }

    /**
     * @param int[] $authors use author id.
     */
    public function byAuthorIn(int ...$authors): static
    {
        $new = clone $this;

        $new->addExpression(AuthorInExpr::class, $authors);

        return $new;
    }

    /**
     * @param int[] $authors use author id
     */
    public function byAuthorNotIn(int ...$authors): static
    {
        $new = clone $this;

        $new->addExpression(AuthorNotInExpr::class, $authors);

        return $new;
    }
}