<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\CustomField;

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CustomFieldExpr::class)]
class CustomFieldExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new CustomFieldExpr();

        $actual = $obj->toQuery([]);
        $this->assertEquals([], $actual);
    }

    public function test_toQuery_oneParam(): void
    {
        $obj = new CustomFieldExpr();

        $actual = $obj->toQuery([['hoge', 'HOGE', '=', 'CHAR']]);
        $this->assertEquals([
            'meta_query' => [
                [
                    'key' => 'hoge',
                    'value' => 'HOGE',
                    'compare' => '=',
                    'type' => 'CHAR',
                ],
            ],
        ], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new CustomFieldExpr();

        $actual = $obj->toQuery([
            ['hoge', 'HOGE', '=', 'CHAR'],
            ['fuga', ['2023-01-01', '2023-12-31'], 'BETWEEN', 'DATE'],
            ['piyo', 3, '<', 'NUMERIC'],
        ]);
        $this->assertEquals([
            [
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
                        'value' => [
                            '2023-01-01',
                            '2023-12-31',
                        ],
                        'compare' => 'BETWEEN',
                        'type' => 'DATE',
                    ],
                    [
                        'key' => 'piyo',
                        'value' => 3,
                        'compare' => '<',
                        'type' => 'NUMERIC',
                    ],
                ],
            ]
        ], $actual);
    }

    public function test_toQuery_oneParamNoTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('field');
        $obj = new CustomFieldExpr();

        $obj->toQuery([[]]);
    }

    public function test_toQuery_oneParamOneTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('value');
        $obj = new CustomFieldExpr();

        $obj->toQuery([['hoge']]);
    }

    public function test_toQuery_oneParamTwoTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('compare');
        $obj = new CustomFieldExpr();

        $obj->toQuery([['hoge', 'HOGE']]);
    }

    public function test_toQuery_oneParamThreeTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('type');
        $obj = new CustomFieldExpr();

        $obj->toQuery([['hoge', 'HOGE', '=']]);
    }
}