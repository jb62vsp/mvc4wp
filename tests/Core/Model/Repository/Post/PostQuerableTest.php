<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Post;

use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostQuerable::class)]
class PostQuerableTest extends TestCase
{
    public function test_byID_single(): void
    {
        $obj = new PostQuerableTestMockImpl();

        $actual = $obj
            ->byID(1)
            ->getExpressions();
        $this->assertEquals([PostIDExpr::class => [1]], $actual);
    }

    public function test_byID_chain(): void
    {
        $obj = new PostQuerableTestMockImpl();

        $actual = $obj
            ->byID(1)
            ->byID(2)
            ->byID(3)
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([PostIDExpr::class => [3]], $actual);
    }

    public function test_bySlug_single(): void
    {
        $obj = new PostQuerableTestMockImpl();

        $actual = $obj
            ->bySlug('hoge')
            ->getExpressions();
        $this->assertEquals([PostNameExpr::class => ['hoge']], $actual);
    }

    public function test_bySlug_chain(): void
    {
        $obj = new PostQuerableTestMockImpl();

        $actual = $obj
            ->bySlug('hoge')
            ->bySlug('fuga')
            ->bySlug('piyo')
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([PostNameExpr::class => ['piyo']], $actual);
    }

    public function test_byPageID_single(): void
    {
        $obj = new PostQuerableTestMockImpl();

        $actual = $obj
            ->byPageID(1)
            ->getExpressions();
        $this->assertEquals([PostPageIDExpr::class => [1]], $actual);
    }

    public function test_byPageID_chain(): void
    {
        $obj = new PostQuerableTestMockImpl();

        $actual = $obj
            ->byPageID(1)
            ->byPageID(2)
            ->byPageID(3)
            ->getExpressions();
        $this->assertEquals([PostPageIDExpr::class => [3]], $actual);
    }

    public function test_byPageSlug_single(): void
    {
        $obj = new PostQuerableTestMockImpl();

        $actual = $obj
            ->byPageSlug('hoge')
            ->getExpressions();
        $this->assertEquals([PostPageNameExpr::class => ['hoge']], $actual);
    }

    public function test_byPageSlug_chain(): void
    {
        $obj = new PostQuerableTestMockImpl();

        $actual = $obj
            ->byPageSlug('hoge')
            ->byPageSlug('fuga')
            ->byPageSlug('piyo')
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([PostPageNameExpr::class => ['piyo']], $actual);
    }
}

class PostQuerableTestMockImpl
{
    use Querable, PostQuerable;
}