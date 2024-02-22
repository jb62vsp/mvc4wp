<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Search;

use Mvc4Wp\Core\Model\Query\Expr;

class SearchExpr implements Expr
{
    public function __construct(
        protected string $keyword,
    ) {
    }

    public function toQuery(): array
    {
        return ['s' => $this->keyword];
    }
}