<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostType;

use Mvc4Wp\Core\Model\Repository\PostType\PostTypeExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostTypeExpr::class)]
class PostTypeExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new PostTypeExpr();

        $actual = $obj->toQuery([]);
        $this->assertEquals([], $actual);
    }

    public function test_toQuery_oneParam(): void
    {
        $obj = new PostTypeExpr();

        $actual = $obj->toQuery(['hoge']);
        $this->assertEquals([['post_type' => 'hoge']], $actual);
    }

    public function test_toQuery_manyParams(): void
    {
        $obj = new PostTypeExpr();

        $actual = $obj->toQuery(['hoge', 'fuga', 'piyo']);
        $this->assertEquals([['post_type' => ['hoge', 'fuga', 'piyo']]], $actual);
    }
}