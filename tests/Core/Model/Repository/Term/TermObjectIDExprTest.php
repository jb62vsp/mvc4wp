<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TermObjectIDExpr::class)]
class TermObjectIDExprTest extends TestCase
{
    public function test_toQuery_noParams(): void
    {
        $obj = new TermObjectIDExpr();

        $actual = $obj->toQuery([], ['hoge' => 'HOGE']);
        $this->assertEquals(['hoge' => 'HOGE'], $actual);
    }

    public function test_toQuery_oneParam(): void
    {
        $obj = new TermObjectIDExpr();

        $actual = $obj->toQuery([1], []);
        $this->assertEquals(['object_ids' => 1], $actual);
    }

    public function test_toQuery_manyParams(): void
    {
        $obj = new TermObjectIDExpr();

        $actual = $obj->toQuery([1, 2, 3], []);
        $this->assertEquals(['object_ids' => [1, 2, 3]], $actual);
    }
}