<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Model\Attribute\Entry;
use Mvc4Wp\Core\Model\TermEntity;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_term_query/__construct/#parameters
 */
trait TermQuerable
{
    /**
     * as Entity classes
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
     * a category.
     */
    public function asCategory(string $taxonomy = ''): static
    {
        $new = clone $this;

        $category = ($taxonomy === '' ? 'category' : $taxonomy);
        $new->addExpression(TermTaxonomyExpr::class, $category);

        return $new;
    }

    /**
     * a tag.
     */
    public function asTag(string $taxonomy = ''): static
    {
        $new = clone $this;

        $tag = ($taxonomy === '' ? 'post_tag' : $taxonomy);
        $new->addExpression(TermTaxonomyExpr::class, $tag);

        return $new;
    }

    /**
     * @param string $name term name.
     */
    public function byName(string $name): static
    {
        $new = clone $this;

        $new->setExpression(TermNameExpr::class, $name);

        return $new;
    }

    /**
     * @param string $slug term slug.
     */
    public function bySlug(string $slug): static
    {
        $new = clone $this;

        $new->setExpression(TermSlugExpr::class, $slug);

        return $new;
    }

    /**
     * @param int $ID post ID.
     */
    public function byPostID(int $ID): static
    {
        $new = clone $this;

        $new->setExpression(TermObjectIDExpr::class, strval($ID));

        return $new;
    }

    /**
     * show empty.
     */
    public function showEmpty()
    {
        $new = clone $this;

        $new->setExpression(TermHideEmptyExpr::class, intval(false));

        return $new;
    }

    /**
     * hide empty.
     */
    public function hideEmpty()
    {
        $new = clone $this;

        $new->setExpression(TermHideEmptyExpr::class, intval(true));

        return $new;
    }
}