<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TermHideEmptyExpr::class)]
class TermHideEmptyExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new TermHideEmptyExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleParam_true(): void
    {
        $obj = new TermHideEmptyExpr();

        $actual = $obj->toQuery([1], []);
        $this->assertEquals(['hide_empty' => true], $actual);
    }

    public function test_toQuery_singleParam_false(): void
    {
        $obj = new TermHideEmptyExpr();

        $actual = $obj->toQuery([0], []);
        $this->assertEquals(['hide_empty' => false], $actual);
    }

    public function test_toQuery_multiParam(): void
    {
        $obj = new TermHideEmptyExpr();

        $actual = $obj->toQuery([1, 0], []);
        $this->assertEquals(['hide_empty' => true], $actual);
    }
}