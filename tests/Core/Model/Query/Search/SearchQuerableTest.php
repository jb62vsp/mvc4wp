<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\Search;

use Mvc4Wp\Core\Model\Query\Search\SearchExpr;
use Mvc4Wp\Core\Model\Query\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SearchQuerable::class)]
class SearchQuerableTest extends TestCase
{
    public function test_search_single(): void
    {
        $obj = new SearchQuerableTestMockImpl();

        $actual = $obj
            ->search('hoge')
            ->getExpressions();
        $this->assertEquals([SearchExpr::class => ['hoge']], $actual);
    }

    public function test_search_chain(): void
    {
        $obj = new SearchQuerableTestMockImpl();

        $actual = $obj
            ->search('hoge')
            ->search('fuga')
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([SearchExpr::class => ['fuga']], $actual);
    }
}

class SearchQuerableTestMockImpl
{
    use Querable, SearchQuerable;
}