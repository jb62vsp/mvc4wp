<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostPaginate;

use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostPaginateQuerable::class)]
class PostPaginateQuerableTest extends TestCase
{
    public function test_all(): void
    {
        $obj = new PostPaginateQuerableTestMock();

        $actual = $obj
            ->all()
            ->getExpressions();
        $this->assertEquals([
            PostPaginateExpr::class => [
                [-1, -1],
            ]
        ], $actual);
    }

    public function test_limitOf_single(): void
    {
        $obj = new PostPaginateQuerableTestMock();

        $actual = $obj
            ->limitOf(10, 1)
            ->getExpressions();
        $this->assertEquals([
            PostPaginateExpr::class => [
                [10, 1],
            ]
        ], $actual);
    }

    public function test_limitOf_chain(): void
    {
        $obj = new PostPaginateQuerableTestMock();

        $actual = $obj
            ->limitOf(10, 1)
            ->limitOf(10, 2)
            ->limitOf(10, 3)
            ->getExpressions();
        $this->assertEquals([
            PostPaginateExpr::class => [
                [10, 3],
            ]
        ], $actual);
    }
}

class PostPaginateQuerableTestMock
{
    use Querable, PostPaginateQuerable;
}