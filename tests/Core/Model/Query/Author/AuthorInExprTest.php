<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Author;

use Mvc4Wp\Core\Model\Query\Author\AuthorInExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthorInExpr::class)]
class AuthorInExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new AuthorInExpr();

        $actual = $obj->toQuery([]);
        $this->assertEquals(['author__in' => []], $actual);
    }

    public function test_toQuery_oneParam(): void
    {
        $obj = new AuthorInExpr();

        $actual = $obj->toQuery([1]);
        $this->assertEquals(['author__in' => [1]], $actual);
    }

    public function test_toQuery_manyParams(): void
    {
        $obj = new AuthorInExpr();

        $actual = $obj->toQuery([1, 2, 3]);
        $this->assertEquals(['author__in' => [1, 2, 3]], $actual);
    }
}