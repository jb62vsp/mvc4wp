<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\PostType;

use Mvc4Wp\Core\Model\Query\Expr;

class PostTypeExpr implements Expr
{
    /**
     * @var array<string> $post_types
     */
    protected array $post_types;

    public function __construct(
        string ...$post_types,
    ) {
        $this->post_types = $post_types;
    }

    public function toQuery(): array
    {
        if (empty($this->post_types)) {
            return [];
        } elseif (count($this->post_types) === 1) {
            return ['post_type' => $this->post_types[0]];
        } else {
            return ['post_type' => $this->post_types];
        }
    }
}