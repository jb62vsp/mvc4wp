<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Order;

use Mvc4Wp\Core\Model\Repository\OrderInQuery;
use Mvc4Wp\Core\Model\Repository\Querable;
use Mvc4Wp\Core\Model\Repository\TypeInQuery;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(OrderQuerable::class)]
class OrderQuerableTest extends TestCase
{
    public function test_orderBy_noOrder(): void
    {
        $obj = new OrderQuerableTestMockImpl();

        $actual = $obj
            ->orderBy('hoge')
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['hoge' => ['ASC', 'CHAR']]], $actual);
    }

    public function test_orderBy_chain(): void
    {
        $obj = new OrderQuerableTestMockImpl();

        $actual = $obj
            ->orderBy('hoge')
            ->orderBy('fuga', type: TypeInQuery::TIME)
            ->orderBy('piyo', OrderInQuery::DESC, TypeInQuery::BINARY)
            ->getExpressions();
        $this->assertEquals([
            OrderByExpr::class => [
                'hoge' => [
                    'ASC',
                    'CHAR',
                ],
                'fuga' => [
                    'ASC',
                    'TIME'
                ],
                'piyo' => [
                    'DESC',
                    'BINARY',
                ],
            ],
        ], $actual);
    }

    public function test_orderByID_noOrder(): void
    {
        $obj = new OrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByID()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['ID' => ['ASC', '']]], $actual);
    }

    public function test_orderByID_withOrder(): void
    {
        $obj = new OrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByID(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['ID' => ['DESC', '']]], $actual);
    }

    public function test_orderByID_chain(): void
    {
        $obj = new OrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByID(OrderInQuery::DESC)
            ->orderByID()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['ID' => ['ASC', '']]], $actual);
    }

    public function test_orderByName_noOrder(): void
    {
        $obj = new OrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByName()
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['name' => ['ASC', '']]], $actual);
    }

    public function test_orderByName_withOrder(): void
    {
        $obj = new OrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByName(OrderInQuery::DESC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['name' => ['DESC', '']]], $actual);
    }

    public function test_orderByName_chain(): void
    {
        $obj = new OrderQuerableTestMockImpl();

        $actual = $obj
            ->orderByName(OrderInQuery::DESC)
            ->orderByName(OrderInQuery::ASC)
            ->getExpressions();
        $this->assertEquals([OrderByExpr::class => ['name' => ['ASC', '']]], $actual);
    }
}

class OrderQuerableTestMockImpl
{
    use Querable, OrderQuerable;
}