<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\PostType;

use Mvc4Wp\Core\Model\Model;
use Mvc4Wp\Core\Model\PostType;

/**
 * @template TModel of Model
 */
trait PostTypeQuerable
{
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
}