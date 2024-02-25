<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Author;

use Mvc4Wp\Core\Model\Repository\Author\AuthorNameExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthorNameExpr::class)]
class AuthorNameExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new AuthorNameExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_singleParam(): void
    {
        $obj = new AuthorNameExpr();

        $actual = $obj->toQuery(['hoge'], []);
        $this->assertEquals(['author_name' => 'hoge'], $actual);
    }

    public function test_toQuery_multiParams(): void
    {
        $obj = new AuthorNameExpr();

        $actual = $obj->toQuery(['hoge', 'fuga', 'piyo'], []);
        $this->assertEquals(['author_name' => 'hoge'], $actual);
    }
}