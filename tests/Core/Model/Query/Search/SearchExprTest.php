<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Search;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SearchExpr::class)]
class SearchExprTest extends TestCase
{
    public function test_toQuery(): void
    {
        $obj = new SearchExpr('s_hino');

        $actual = $obj->toQuery();
        $this->assertEquals(['s' => 's_hino'], $actual);
    }
}