<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Query\ReturnFields;

use Mvc4Wp\Core\Model\Query\ReturnFields\ReturnFieldsExpr;
use Mvc4Wp\Core\Model\Query\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ReturnFieldsQuerable::class)]
class ReturnFieldsQuerableTest extends TestCase
{
    public function test_fetchAll_single(): void
    {
        $obj = new ReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchAll()
            ->getExpressions();
        $this->assertEquals([ReturnFieldsExpr::class => ['all']], $actual);
    }

    public function test_fetchAll_chain(): void
    {
        $obj = new ReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchAll()
            ->fetchAll()
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([ReturnFieldsExpr::class => ['all']], $actual);
    }

    public function test_fetchOnlyID_single(): void
    {
        $obj = new ReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchOnlyID()
            ->getExpressions();
        $this->assertEquals([ReturnFieldsExpr::class => ['ids']], $actual);
    }

    public function test_fetchOnlyID_chain(): void
    {
        $obj = new ReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchOnlyID()
            ->fetchOnlyID()
            ->getExpressions();
        $this->assertEquals([ReturnFieldsExpr::class => ['ids']], $actual);
    }

    public function test_parent_single(): void
    {
        $obj = new ReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->parent()
            ->getExpressions();
        $this->assertEquals([ReturnFieldsExpr::class => ['id=>parent']], $actual);
    }

    public function test_parent_chain(): void
    {
        $obj = new ReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->parent()
            ->parent()
            ->getExpressions();
        $this->assertEquals([ReturnFieldsExpr::class => ['id=>parent']], $actual);
    }

    public function test_chain(): void
    {
        $obj = new ReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchAll()
            ->fetchOnlyID()
            ->parent()
            ->getExpressions();
        $this->assertEquals([ReturnFieldsExpr::class => ['id=>parent']], $actual);
    }
}

class ReturnFieldsQuerableTestMockImpl
{
    use Querable, ReturnFieldsQuerable;
}