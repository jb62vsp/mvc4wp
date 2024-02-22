<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Author;

use Mvc4Wp\Core\Model\Query\Expr;

class AuthorExpr implements Expr
{
    public function __construct(
        protected int $author_id,
    ) {
    }

    public function toQuery(): array
    {
        return ['author' => $this->author_id];
    }
}