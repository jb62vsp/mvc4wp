<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostSearch;

use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostSearchQuerable::class)]
class PostSearchQuerableTest extends TestCase
{
    public function test_search_single(): void
    {
        $obj = new PostSearchQuerableTestMockImpl();

        $actual = $obj
            ->search('hoge')
            ->getExpressions();
        $this->assertEquals([PostSearchExpr::class => ['hoge']], $actual);
    }

    public function test_search_chain(): void
    {
        $obj = new PostSearchQuerableTestMockImpl();

        $actual = $obj
            ->search('hoge')
            ->search('fuga')
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([PostSearchExpr::class => ['fuga']], $actual);
    }
}

class PostSearchQuerableTestMockImpl
{
    use Querable, PostSearchQuerable;
}