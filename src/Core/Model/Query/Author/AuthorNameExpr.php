<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Author;

use Mvc4Wp\Core\Model\Query\Expr;

class AuthorNameExpr implements Expr
{
    public function __construct(
        protected string $author_name,
    ) {
    }

    public function toQuery(): array
    {
        return ['author_name' => $this->author_name];
    }
}