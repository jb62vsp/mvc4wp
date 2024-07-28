<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Post;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostNameExpr::class)]
class PostNameExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new PostNameExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new PostNameExpr();

        $actual = $obj->toQuery([1], []);
        $this->assertEquals(['name' => 1], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new PostNameExpr();

        $actual = $obj->toQuery([1, 2, 3], []);
        $this->assertEquals(['name' => 1], $actual);
    }
}