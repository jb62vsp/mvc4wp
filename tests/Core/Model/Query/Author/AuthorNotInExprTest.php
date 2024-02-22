<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Author;

use Mvc4Wp\Core\Model\Query\Author\AuthorNotInExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthorNotInExpr::class)]
class AuthorNotInExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new AuthorNotInExpr();

        $actual = $obj->toQuery();
        $this->assertEquals([], $actual);
    }

    public function test_toQuery_oneParam(): void
    {
        $obj = new AuthorNotInExpr(1);

        $actual = $obj->toQuery();
        $this->assertEquals(['author__not_in' => [1]], $actual);
    }

    public function test_toQuery_manyParams(): void
    {
        $obj = new AuthorNotInExpr(1, 2, 3);

        $actual = $obj->toQuery();
        $this->assertEquals(['author__not_in' => [1, 2, 3]], $actual);
    }
}