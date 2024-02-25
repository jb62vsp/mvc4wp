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
        $this->assertEquals([PostPageIDExpr::class => [1]], $actual);
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
        $this->assertEquals([PostPageIDExpr::class => [3]], $actual);
    }
}

class PostQuerableTestMockImpl
{
    use Querable, PostQuerable;
}