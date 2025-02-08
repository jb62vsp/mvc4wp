<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use Mvc4Wp\Core\Model\Attribute\Entry;
use Mvc4Wp\Core\Model\TermEntity;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_term_query/__construct/#parameters
 */
trait TermQuerable
{
    /**
     * As Entity classes
     */
    public function asEntity(string ...$classes): static
    {
        $new = clone $this;

        $post_types = [];
        foreach ($classes as $class) {
            if (TermEntity::extended($class)) {
                $post_types[] = Entry::getName($class);
            }
        }
        $new->addExpression(TermTaxonomyExpr::class, $post_types);

        return $new;
    }

    /**
     * As category name.
     */
    public function asCategory(string $taxonomy = ''): static
    {
        $new = clone $this;

        $category = ($taxonomy === '' ? 'category' : $taxonomy);
        $new->addExpression(TermTaxonomyExpr::class, $category);

        return $new;
    }

    /**
     * As tag name.
     */
    public function asTag(string $taxonomy = ''): static
    {
        $new = clone $this;

        $tag = ($taxonomy === '' ? 'post_tag' : $taxonomy);
        $new->addExpression(TermTaxonomyExpr::class, $tag);

        return $new;
    }

    /**
     * Term ID to return term for.
     * @param string $name Trm name.
     */
    public function byTermID(int ...$ids): static
    {
        $new = clone $this;

        $new->setExpression(TermTaxonomyIDExpr::class, $ids);

        return $new;
    }

    /**
     * Name to return term for.
     * @param string $name Trm name.
     */
    public function byName(string $name): static
    {
        $new = clone $this;

        $new->setExpression(TermNameExpr::class, $name);

        return $new;
    }

    /**
     * Slug to return term for.
     * @param string $slug Term slug.
     */
    public function bySlug(string $slug): static
    {
        $new = clone $this;

        $new->setExpression(TermSlugExpr::class, $slug);

        return $new;
    }

    /**
     * Post ID to return term for.
     * @param int $ID post ID.
     */
    public function byPostID(int $ID): static
    {
        $new = clone $this;

        $new->setExpression(TermObjectIDExpr::class, strval($ID));

        return $new;
    }

    /**
     * Show empty.
     */
    public function showEmpty(): static
    {
        $new = clone $this;

        $new->setExpression(TermHideEmptyExpr::class, intval(false));

        return $new;
    }

    /**
     * Hide empty.
     */
    public function hideEmpty(): static
    {
        $new = clone $this;

        $new->setExpression(TermHideEmptyExpr::class, intval(true));

        return $new;
    }

    /**
     * Include ids.
     */
    public function include(int ...$ids): static
    {
        $new = clone $this;

        $new->setExpression(TermIncludeExpr::class, $ids);

        return $new;
    }

    /**
     * Exclude ids.
     */
    public function exclude(int ...$ids): static
    {
        $new = clone $this;

        $new->setExpression(TermExcludeExpr::class, $ids);

        return $new;
    }

    /**
     * Exclude tree ids.
     */
    public function excludeTree(int ...$ids): static
    {
        $new = clone $this;

        $new->setExpression(TermExcludeTreeExpr::class, $ids);

        return $new;
    }

    /**
     * Maximum number of terms to return.
     */
    public function count(int $count): static
    {
        $new = clone $this;

        $new->setExpression(TermNumberExpr::class, $count);

        return $new;
    }

    /**
     * The number by which to offset the terms query.
     */
    public function offset(int $offset): static
    {
        $new = clone $this;

        $new->setExpression(TermOffsetExpr::class, $offset);

        return $new;
    }

    /**
     * Search criteria to match terms.
     * 
     * @param string $search Search keyword.
     */
    public function search(string $search): static
    {
        $new = clone $this;

        $new->setExpression(TermSearchExpr::class, $search);

        return $new;
    }

    /**
     * All retrieve child terms of.
     */
    public function allChildren(int $parent): static
    {
        $new = clone $this;

        $new->setExpression(TermChildOfExpr::class, $parent);

        return $new;
    }

    /**
     * Direct retrieve child terms of.
     */
    public function directChildren(int $parent): static
    {
        $new = clone $this;

        $new->setExpression(TermParentExpr::class, $parent);

        return $new;
    }

    /**
     * Top of hierarchy.
     */
    public function top(): static
    {
        $new = clone $this;

        $new->setExpression(TermParentExpr::class, 0);

        return $new;
    }

    /**
     * True to limit results to terms that have no children.
     */
    public function childless(): static
    {
        $new = clone $this;

        $new->setExpression(TermChildlessExpr::class, intval(true));

        return $new;
    }
}