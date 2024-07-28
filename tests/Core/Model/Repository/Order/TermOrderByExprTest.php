<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TermOrderByExpr::class)]
class TermOrderByExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new TermOrderByExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleEmbeddedParam(): void
    {
        $obj = new TermOrderByExpr();

        $actual = $obj->toQuery([
            'name' => 'ASC',
        ], []);
        $this->assertEquals([
            'orderby' => 'name',
            'order' => 'ASC',
        ], $actual);
    }

    public function test_toQuery_singleCustomParam(): void
    {
        $obj = new TermOrderByExpr();

        $actual = $obj->toQuery([
            'hoge' => 'ASC',
        ], []);
        $this->assertEquals([
            'orderby' => 'meta_value',
            'meta_key' => 'hoge',
            'order' => 'ASC',
        ], $actual);
    }
}