<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Author;

use Mvc4Wp\Core\Model\Query\Expr;

class AuthorNotInExpr implements Expr
{
    /**
     * @var array<int> $authors
     */
    protected array $authors;

    /**
     * @param array<int> $authors
     */
    public function __construct(
        int ...$authors
    ) {
        $this->authors = $authors;
    }

    public function toQuery(): array
    {
        if (empty($this->authors)) {
            return [];
        } else {
            return ['author__not_in' => $this->authors];
        }
    }
}