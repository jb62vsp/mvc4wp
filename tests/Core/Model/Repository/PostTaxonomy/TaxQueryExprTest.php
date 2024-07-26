<?php declare(strict_types=1);

use Mvc4Wp\Core\Exception\QueryBuildViolationException;
use Mvc4Wp\Core\Model\Repository\PostTaxonomy\TaxQueryExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TaxQueryExpr::class)]
class TaxQueryExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new TaxQueryExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_oneParam(): void
    {
        $obj = new TaxQueryExpr();

        $actual = $obj->toQuery([
            ['hoge', 'slug', 'fuga', true, 'IN'],
        ], []);
        $this->assertEquals([
            'tax_query' => [
                [
                    'taxonomy' => 'hoge',
                    'field' => 'slug',
                    'terms' => 'fuga',
                    'include_children' => true,
                    'operator' => 'IN',
                ],
            ],
        ], $actual);
    }

    public function test_toQuery_oneParamWithQuery(): void
    {
        $obj = new TaxQueryExpr();

        $actual = $obj->toQuery([
            ['hoge', 'slug', 'fuga', true, 'IN'],
        ], [
            'tax_query' => [
                [
                    'taxonomy' => 'piyo',
                    'field' => 'term_id',
                    'terms' => [1, 2,],
                    'include_children' => false,
                    'operator' => 'AND',
                ]
            ],
        ]);
        $this->assertEquals([
            'tax_query' => [
                'relation' => 'AND',
                [
                    'taxonomy' => 'piyo',
                    'field' => 'term_id',
                    'terms' => [1, 2,],
                    'include_children' => false,
                    'operator' => 'AND',
                ],
                [
                    'taxonomy' => 'hoge',
                    'field' => 'slug',
                    'terms' => 'fuga',
                    'include_children' => true,
                    'operator' => 'IN',
                ],
            ],
        ], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new TaxQueryExpr();

        $actual = $obj->toQuery([
            ['hoge', 'slug', 'fuga', true, 'IN'],
            ['piyo', 'term_id', [1, 2,], false, 'AND'],
        ], []);
        $this->assertEquals([
            'tax_query' => [
                'relation' => 'AND',
                [
                    'taxonomy' => 'hoge',
                    'field' => 'slug',
                    'terms' => 'fuga',
                    'include_children' => true,
                    'operator' => 'IN',
                ],
                [
                    'taxonomy' => 'piyo',
                    'field' => 'term_id',
                    'terms' => [1, 2,],
                    'include_children' => false,
                    'operator' => 'AND',
                ],
            ],
        ], $actual);
    }

    public function test_toQuery_oneParamNoTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('taxonomy');
        $obj = new TaxQueryExpr();

        $obj->toQuery([[]], []);
    }

    public function test_toQuery_oneParamOneTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('field');
        $obj = new TaxQueryExpr();

        $obj->toQuery([['hoge']], []);
    }

    public function test_toQuery_oneParamTwoTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('terms');
        $obj = new TaxQueryExpr();

        $obj->toQuery([['hoge', 'slug']], []);
    }

    public function test_toQuery_oneParamThreeTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('include_children');
        $obj = new TaxQueryExpr();

        $obj->toQuery([['hoge', 'slug', 'fuga']], []);
    }

    public function test_toQuery_oneParamFourTuple(): void
    {
        $this->expectException(QueryBuildViolationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('operator');
        $obj = new TaxQueryExpr();

        $obj->toQuery([['hoge', 'slug', 'fuga', true]], []);
    }
}