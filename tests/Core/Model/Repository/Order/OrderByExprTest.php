<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Exception\ApplicationException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderByExpr::class)]
class OrderByExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new OrderByExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleEmbeddedParam(): void
    {
        $obj = new OrderByExpr();

        $actual = $obj->toQuery([
            'ID' => ['ASC', ''],
        ], []);
        $this->assertEquals([
            'orderby' => ['ID' => 'ASC'],
        ], $actual);
    }

    public function test_toQuery_multiEmbeddedParams(): void
    {
        $obj = new OrderByExpr();

        $actual = $obj->toQuery([
            'ID' => ['ASC', ''],
            'name' => ['DESC', ''],
            'author' => ['ASC', ''],
        ], []);
        $this->assertEquals([
            'orderby' => [
                'ID' => 'ASC',
                'name' => 'DESC',
                'author' => 'ASC',
            ],
        ], $actual);
    }

    public function test_toQuery_singleCustomParam(): void
    {
        $obj = new OrderByExpr();

        $actual = $obj->toQuery([
            'hoge' => ['ASC', 'CHAR'],
        ], []);
        $this->assertEquals([
            'meta_query' => [
                'hoge' => [
                    'key' => 'hoge',
                    'compare' => 'EXISTS',
                    'type' => 'CHAR',
                ],
            ],
            'orderby' => [
                'hoge' => 'ASC',
            ],
        ], $actual);
    }

    public function test_toQuery_singleCustomParamWithQuery(): void
    {
        $obj = new OrderByExpr();

        $actual = $obj->toQuery([
            'hoge' => ['ASC', 'CHAR'],
        ], [
            'meta_query' => [
                [
                    'key' => 'hoge',
                    'value' => 'HOGE',
                    'compare' => '=',
                    'type' => 'CHAR',
                ],
            ],
        ]);
        $this->assertEquals([
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'hoge',
                    'value' => 'HOGE',
                    'compare' => '=',
                    'type' => 'CHAR',
                ],
                'hoge' => [
                    'key' => 'hoge',
                    'compare' => 'EXISTS',
                    'type' => 'CHAR',
                ],
            ],
            'orderby' => ['hoge' => 'ASC'],
        ], $actual);
    }

    public function test_toQuery_multiCustomParam(): void
    {
        $obj = new OrderByExpr();

        $actual = $obj->toQuery([
            'hoge' => ['ASC', 'CHAR'],
            'fuga' => ['DESC', 'BINARY'],
            'piyo' => ['DESC', 'NUMERIC'],
        ], []);
        $this->assertEquals([
            'meta_query' => [
                'relation' => 'AND',
                'hoge' => [
                    'key' => 'hoge',
                    'compare' => 'EXISTS',
                    'type' => 'CHAR',
                ],
                'fuga' => [
                    'key' => 'fuga',
                    'compare' => 'EXISTS',
                    'type' => 'BINARY',
                ],
                'piyo' => [
                    'key' => 'piyo',
                    'compare' => 'EXISTS',
                    'type' => 'NUMERIC',
                ],
            ],
            'orderby' => [
                'hoge' => 'ASC',
                'fuga' => 'DESC',
                'piyo' => 'DESC',
            ],
        ], $actual);
    }

    public function test_toQuery_multiCustomParamWithQuery(): void
    {
        $obj = new OrderByExpr();

        $actual = $obj->toQuery([
            'hoge' => ['ASC', 'CHAR'],
            'fuga' => ['DESC', 'BINARY'],
            'piyo' => ['DESC', 'NUMERIC'],
        ], [
            'meta_query' => [
                [
                    'key' => 'hoge',
                    'value' => 'HOGE',
                    'compare' => '=',
                    'type' => 'CHAR',
                ],
            ],
        ]);
        $this->assertEquals([
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'hoge',
                    'value' => 'HOGE',
                    'compare' => '=',
                    'type' => 'CHAR',
                ],
                'hoge' => [
                    'key' => 'hoge',
                    'compare' => 'EXISTS',
                    'type' => 'CHAR',
                ],
                'fuga' => [
                    'key' => 'fuga',
                    'compare' => 'EXISTS',
                    'type' => 'BINARY',
                ],
                'piyo' => [
                    'key' => 'piyo',
                    'compare' => 'EXISTS',
                    'type' => 'NUMERIC',
                ],
            ],
            'orderby' => [
                'hoge' => 'ASC',
                'fuga' => 'DESC',
                'piyo' => 'DESC',
            ],
        ], $actual);
    }

    public function test_toQuery_multiCustomParamWithMultiQuery(): void
    {
        $obj = new OrderByExpr();

        $actual = $obj->toQuery([
            'hoge' => ['ASC', 'CHAR'],
            'fuga' => ['DESC', 'BINARY'],
            'piyo' => ['DESC', 'NUMERIC'],
        ], [
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'hoge',
                    'value' => 'HOGE',
                    'compare' => '=',
                    'type' => 'CHAR',
                ],
                [
                    'key' => 'fuga',
                    'value' => 'FUGA',
                    'compare' => '=',
                    'type' => 'CHAR',
                ],
            ],
        ]);
        $this->assertEquals([
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => 'hoge',
                    'value' => 'HOGE',
                    'compare' => '=',
                    'type' => 'CHAR',
                ],
                [
                    'key' => 'fuga',
                    'value' => 'FUGA',
                    'compare' => '=',
                    'type' => 'CHAR',
                ],
                'hoge' => [
                    'key' => 'hoge',
                    'compare' => 'EXISTS',
                    'type' => 'CHAR',
                ],
                'fuga' => [
                    'key' => 'fuga',
                    'compare' => 'EXISTS',
                    'type' => 'BINARY',
                ],
                'piyo' => [
                    'key' => 'piyo',
                    'compare' => 'EXISTS',
                    'type' => 'NUMERIC',
                ],
            ],
            'orderby' => [
                'hoge' => 'ASC',
                'fuga' => 'DESC',
                'piyo' => 'DESC',
            ],
        ], $actual);
    }

    public function test_toQuery_noTuple(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('order');
        $obj = new OrderByExpr();
        $obj->toQuery(['ID' => []], []);
    }

    public function test_toQuery_oneTuple(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('type');
        $obj = new OrderByExpr();
        $obj->toQuery(['ID' => ['ASC']], []);
    }
}