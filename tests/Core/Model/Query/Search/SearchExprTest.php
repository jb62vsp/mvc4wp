<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Search;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SearchExpr::class)]
class SearchExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new SearchExpr();

        $actual = $obj->toQuery([]);
        $this->assertEquals([], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new SearchExpr();

        $actual = $obj->toQuery(['hoge']);
        $this->assertEquals(['s' => 'hoge'], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new SearchExpr();

        $actual = $obj->toQuery(['hoge', 'fuga', 'piyo']);
        $this->assertEquals(['s' => 'hoge'], $actual);
    }
}