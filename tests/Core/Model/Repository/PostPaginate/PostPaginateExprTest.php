<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostPaginate;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostPaginateExpr::class)]
class PostPaginateExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new PostPaginateExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new PostPaginateExpr();

        $actual = $obj->toQuery([
            [10, 1]
        ], []);
        $this->assertEquals([
            'posts_per_page' => 10,
            'paged' => 1,
        ], $actual);
    }

    public function test_toQuery_singleParamWithMinus(): void
    {
        $obj = new PostPaginateExpr();

        $actual = $obj->toQuery([
            [-1, -1]
        ], []);
        $this->assertEquals([
            'posts_per_page' => -1,
        ], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new PostPaginateExpr();

        $actual = $obj->toQuery([
            [10, 1],
            [10, 2],
            [10, 3],
        ], []);
        $this->assertEquals([
            'posts_per_page' => 10,
            'paged' => 1,
        ], $actual);
    }

    public function test_toQuery_noTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('count');

        $obj = new PostPaginateExpr();

        $obj->toQuery([
            []
        ], []);
    }

    public function test_toQuery_oneTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('page');

        $obj = new PostPaginateExpr();

        $obj->toQuery([
            [-1]
        ], []);
    }
}