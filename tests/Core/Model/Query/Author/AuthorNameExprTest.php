<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Author;

use Mvc4Wp\Core\Model\Query\Author\AuthorNameExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthorNameExpr::class)]
class AuthorNameExprTest extends TestCase
{
    public function test_toQuery(): void
    {
        $obj = new AuthorNameExpr('s_hino');

        $actual = $obj->toQuery();
        $this->assertEquals(['author_name' => 's_hino'], $actual);
    }
}