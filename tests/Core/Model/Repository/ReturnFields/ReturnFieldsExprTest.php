<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\ReturnFields;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReturnFieldsExpr::class)]
class ReturnFieldsExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new ReturnFieldsExpr();

        $actual = $obj->toQuery([]);
        $this->assertEquals([], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new ReturnFieldsExpr();

        $actual = $obj->toQuery(['hoge']);
        $this->assertEquals(['fields' => 'hoge'], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new ReturnFieldsExpr();

        $actual = $obj->toQuery(['hoge', 'fuga', 'piyo']);
        $this->assertEquals(['fields' => 'hoge'], $actual);
    }
}