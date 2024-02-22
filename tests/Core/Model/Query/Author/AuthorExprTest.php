<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Author;

use Mvc4Wp\Core\Model\Query\Author\AuthorExpr;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AuthorExpr::class)]
class AuthorExprTest extends TestCase
{
    public function test_toQuery(): void
    {
        $obj = new AuthorExpr(1);
        
        $actual = $obj->toQuery();
        $this->assertEquals(['author' => 1], $actual);
    }
}