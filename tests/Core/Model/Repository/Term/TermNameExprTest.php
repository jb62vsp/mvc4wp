<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TermNameExpr::class)]
class TermNameExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new TermNameExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new TermNameExpr();

        $actual = $obj->toQuery(['hoge'], []);
        $this->assertEquals(['name' => 'hoge'], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new TermNameExpr();

        $actual = $obj->toQuery(['hoge', 'fuga', 'piyo'], []);
        $this->assertEquals(['name' => 'hoge'], $actual);
    }
}