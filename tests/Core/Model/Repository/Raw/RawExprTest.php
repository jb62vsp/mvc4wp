<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Raw;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RawExpr::class)]
class RawExprTest extends TestCase
{
    public function test_toQuery_empty(): void
    {
        $obj = new RawExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_single(): void
    {
        $obj = new RawExpr();

        $actual = $obj->toQuery([
            'search' => 1,
        ], []);
        $this->assertEquals([
            'search' => 1,
        ], $actual);

    }

    public function test_toQuery_multiWithQuery(): void
    {
        $obj = new RawExpr();

        $actual = $obj->toQuery([
            'search' => 1,
            'search_columns' => ['ID'],
        ], [
            'order' => 'ASC',
            'orderby' => 'ID',
        ]);
        $this->assertEquals([
            'order' => 'ASC',
            'orderby' => 'ID',
            'search' => 1,
            'search_columns' => ['ID'],
        ], $actual);

    }
}