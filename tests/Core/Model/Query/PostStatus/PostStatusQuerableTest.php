<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\PostStatus;

use Mvc4Wp\Core\Model\Model;
use Mvc4Wp\Core\Model\Query\PostStatus\PostStatusExpr;
use Mvc4Wp\Core\Model\Query\PostStatus\PostStatusQuerable;
use Mvc4Wp\Core\Model\Query\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostStatusQuerable::class)]
class PostStatusQuerableTest extends TestCase
{
    public function test_withPublish_single(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withPublish()
            ->getExpressions();
        $this->assertEquals([PostStatusExpr::class => ['publish']], $actual);
    }

    public function test_withPending_single(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withPending()
            ->getExpressions();
        $this->assertEquals([PostStatusExpr::class => ['pending']], $actual);
    }

    public function test_withDraft_single(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withDraft()
            ->getExpressions();
        $this->assertEquals([PostStatusExpr::class => ['draft']], $actual);
    }

    public function test_withAutoDraft_single(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withAutoDraft()
            ->getExpressions();
        $this->assertEquals([PostStatusExpr::class => ['auto-draft']], $actual);
    }

    public function test_withFuture_single(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withFuture()
            ->getExpressions();
        $this->assertEquals([PostStatusExpr::class => ['future']], $actual);
    }

    public function test_withPrivate_single(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withPrivate()
            ->getExpressions();
        $this->assertEquals([PostStatusExpr::class => ['private']], $actual);
    }

    public function test_withInherit_single(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withInherit()
            ->getExpressions();
        $this->assertEquals([PostStatusExpr::class => ['inherit']], $actual);
    }

    public function test_withTrash_single(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withTrash()
            ->getExpressions();
        $this->assertEquals([PostStatusExpr::class => ['trash']], $actual);
    }

    public function test_withAny_single(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withAny()
            ->getExpressions();
        $this->assertEquals([PostStatusExpr::class => ['any']], $actual);
    }

    public function test_chain(): void
    {
        $obj = new PostStatusQuerableTestMockA();

        $actual = $obj
            ->withPublish()
            ->withPending()
            ->withDraft()
            ->withAutoDraft()
            ->withFuture()
            ->withPrivate()
            ->withInherit()
            ->withTrash()
            ->withAny()
            ->getExpressions();
        $this->assertEquals([
            PostStatusExpr::class => [
                'publish',
                'pending',
                'draft',
                'auto-draft',
                'future',
                'private',
                'inherit',
                'trash',
                'any',
            ]
        ], $actual);
    }
}

/**
 * @template T of Model
 */
class PostStatusQuerableTestMockA
{
    /**
     * @use PostStatusQuerable<T>
     */
    use Querable, PostStatusQuerable;
}