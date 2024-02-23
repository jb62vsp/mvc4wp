<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostStatus;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 * @see https://developer.wordpress.org/reference/classes/wp_query/#status-parameters
 */

trait PostStatusQuerable
{
    /**
     * a published post or page.
     */
    public function withPublish(): static
    {
        $new = clone $this;

        $new->addExpression(PostStatusExpr::class, 'publish');

        return $new;
    }

    /**
     * post is pending review.
     */
    public function withPending(): static
    {
        $new = clone $this;

        $new->addExpression(PostStatusExpr::class, 'pending');

        return $new;
    }

    /**
     * a post in draft status.
     */
    public function withDraft(): static
    {
        $new = clone $this;

        $new->addExpression(PostStatusExpr::class, 'draft');

        return $new;
    }

    /**
     * a newly created post, with no content.
     */
    public function withAutoDraft(): static
    {
        $new = clone $this;

        $new->addExpression(PostStatusExpr::class, 'auto-draft');

        return $new;
    }

    /**
     * a post to publish in the future.
     */
    public function withFuture(): static
    {
        $new = clone $this;

        $new->addExpression(PostStatusExpr::class, 'future');

        return $new;
    }

    /**
     * not visible to users who are not logged in.
     */
    public function withPrivate(): static
    {
        $new = clone $this;

        $new->addExpression(PostStatusExpr::class, 'private');

        return $new;
    }

    /**
     * a revision.
     * see get_children() .
     * @see https://developer.wordpress.org/reference/functions/get_children/
     */
    public function withInherit(): static
    {
        $new = clone $this;

        $new->addExpression(PostStatusExpr::class, 'inherit');

        return $new;
    }

    /**
     * post is in trashbin.
     */
    public function withTrash(): static
    {
        $new = clone $this;

        $new->addExpression(PostStatusExpr::class, 'trash');

        return $new;
    }

    /**
     * retrieves any status except for 'inherit', 'trash' and 'auto-draft'.
     * Custom post statuses with 'exclude_from_search' set to true are also excluded.
     */
    public function withAny(): static
    {
        $new = clone $this;

        $new->addExpression(PostStatusExpr::class, 'any');

        return $new;
    }
}