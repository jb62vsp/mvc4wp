<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TermTaxonomyExpr::class)]
class TermTaxonomyExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new TermTaxonomyExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_oneParam(): void
    {
        $obj = new TermTaxonomyExpr();

        $actual = $obj->toQuery(['hoge'], []);
        $this->assertEquals(['taxonomy' => 'hoge'], $actual);
    }

    public function test_toQuery_manyParams(): void
    {
        $obj = new TermTaxonomyExpr();

        $actual = $obj->toQuery(['hoge', 'fuga', 'piyo'], []);
        $this->assertEquals(['taxonomy' => ['hoge', 'fuga', 'piyo']], $actual);
    }
}