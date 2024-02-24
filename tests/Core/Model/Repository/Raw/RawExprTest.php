<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Raw;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RawExpr::class)]
class RawExprTest extends TestCase
{
    public function test_toQuery_empty(): void
    {
        $obj = new RawExpr();

        $actual = $obj->toQuery([]);
        $this->assertEquals([], $actual);
    }

    public function test_toQuery_single(): void
    {
        $obj = new RawExpr();

        $actual = $obj->toQuery([
            ['search' => 1],
            ['search_columns' => ['ID',]],
        ]);
        $this->assertEquals([
            ['search' => 1],
            ['search_columns' => ['ID',]],
        ], $actual);

    }
}