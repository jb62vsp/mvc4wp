<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\PostStatus;

use Mvc4Wp\Core\Model\Query\PostStatus\PostStatusExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostStatusExpr::class)]
class PostStatusExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new PostStatusExpr();

        $actual = $obj->toQuery([]);
        $this->assertEquals([], $actual);
    }

    public function test_toQuery_oneParam(): void
    {
        $obj = new PostStatusExpr();

        $actual = $obj->toQuery(['publish']);
        $this->assertEquals(['post_status' => 'publish'], $actual);
    }

    public function test_toQuery_manyParams(): void
    {
        $obj = new PostStatusExpr();

        $actual = $obj->toQuery(['publish', 'trash', 'draft']);
        $this->assertEquals(['post_status' => ['publish', 'trash', 'draft']], $actual);
    }
}