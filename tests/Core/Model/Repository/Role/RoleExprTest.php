<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Role;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RoleExpr::class)]
class RoleExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new RoleExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new RoleExpr();

        $actual = $obj->toQuery(['hoge'], []);
        $this->assertEquals(['role' => 'hoge'], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new RoleExpr();

        $actual = $obj->toQuery(['hoge', 'fuga', 'piyo'], []);
        $this->assertEquals(['role' => 'hoge'], $actual);
    }
}