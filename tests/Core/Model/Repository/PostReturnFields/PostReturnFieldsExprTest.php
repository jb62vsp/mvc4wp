<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostReturnFields;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostReturnFieldsExpr::class)]
class PostReturnFieldsExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new PostReturnFieldsExpr();

        $actual = $obj->toQuery([]);
        $this->assertEquals([], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new PostReturnFieldsExpr();

        $actual = $obj->toQuery(['hoge']);
        $this->assertEquals(['fields' => 'hoge'], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new PostReturnFieldsExpr();

        $actual = $obj->toQuery(['hoge', 'fuga', 'piyo']);
        $this->assertEquals(['fields' => 'hoge'], $actual);
    }
}