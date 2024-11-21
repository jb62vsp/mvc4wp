<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostType;

use Mvc4Wp\Core\Model\Attribute\PostType;

/**
 * @see https://developer.wordpress.org/reference/classes/wp_query/#post-type-parameters
 */
trait PostTypeQuerable
{
    /**
     * as Post Types
     */
    public function asPostType(string ...$post_types): static
    {
        $new = clone $this;

        $new->addExpression(PostTypeExpr::class, $post_types);

        return $new;
    }

    /**
     * as Entity classes
     */
    public function asEntity(string ...$classes): static
    {
        $new = clone $this;

        $post_types = [];
        foreach ($classes as $class) {
            $post_types[] = PostType::getName($class);
        }
        $new->addExpression(PostTypeExpr::class, $post_types);

        return $new;
    }

    /**
     * a post.
     */
    public function asPost(): static
    {
        $new = clone $this;

        $new->addExpression(PostTypeExpr::class, 'post');

        return $new;
    }

    /**
     * a page.
     */
    public function asPage(): static
    {
        $new = clone $this;

        $new->addExpression(PostTypeExpr::class, 'page');

        return $new;
    }

    /**
     * a revision.
     */
    public function asRevision(): static
    {
        $new = clone $this;

        $new->addExpression(PostTypeExpr::class, 'revision');

        return $new;
    }

    /**
     * an attachment.
     * Whilst the default WP_Query post_status is 'publish', attachments have a default post_status of 'inherit'.
     * This means no attachments will be returned unless you also explicitly set post_status to 'inherit' or 'any'.
     * See Status parameters section below.
     * @see https://developer.wordpress.org/reference/classes/wp_query/#status-parameters
     */
    public function asAttachment(): static
    {
        $new = clone $this;

        $new->addExpression(PostTypeExpr::class, 'attachment');

        return $new;
    }
}