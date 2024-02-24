<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostSearch;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostSearchExpr::class)]
class PostSearchExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new PostSearchExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new PostSearchExpr();

        $actual = $obj->toQuery(['hoge'], []);
        $this->assertEquals(['s' => 'hoge'], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new PostSearchExpr();

        $actual = $obj->toQuery(['hoge', 'fuga', 'piyo'], []);
        $this->assertEquals(['s' => 'hoge'], $actual);
    }
}