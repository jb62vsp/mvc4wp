<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Taxonomy;

use Mvc4Wp\Core\Model\Attribute\Entry;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_term_query/__construct/#parameters
 */
trait TaxonomyQuerable
{
    /**
     * as Entity classes
     */
    public function asEntity(string ...$classes): static
    {
        $new = clone $this;

        $post_types = [];
        foreach ($classes as $class) {
            $post_types[] = Entry::getName($class);
        }
        $new->addExpression(TaxonomyExpr::class, $post_types);

        return $new;
    }

    /**
     * a category.
     */
    public function asCategory(): static
    {
        $new = clone $this;

        $new->addExpression(TaxonomyExpr::class, 'category');

        return $new;
    }

    /**
     * a tag.
     */
    public function asTag(): static
    {
        $new = clone $this;

        $new->addExpression(TaxonomyExpr::class, 'post_tag');

        return $new;
    }
}