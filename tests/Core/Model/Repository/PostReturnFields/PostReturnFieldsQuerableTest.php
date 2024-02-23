<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostReturnFields;

use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostReturnFieldsQuerable::class)]
class PostReturnFieldsQuerableTest extends TestCase
{
    public function test_fetchAll_single(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchAll()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['all']], $actual);
    }

    public function test_fetchAll_chain(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchAll()
            ->fetchAll()
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([PostReturnFieldsExpr::class => ['all']], $actual);
    }

    public function test_fetchOnlyID_single(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchOnlyID()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['ids']], $actual);
    }

    public function test_fetchOnlyID_chain(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchOnlyID()
            ->fetchOnlyID()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['ids']], $actual);
    }

    public function test_parent_single(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->parent()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['id=>parent']], $actual);
    }

    public function test_parent_chain(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->parent()
            ->parent()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['id=>parent']], $actual);
    }

    public function test_chain(): void
    {
        $obj = new PostReturnFieldsQuerableTestMockImpl();

        $actual = $obj
            ->fetchAll()
            ->fetchOnlyID()
            ->parent()
            ->getExpressions();
        $this->assertEquals([PostReturnFieldsExpr::class => ['id=>parent']], $actual);
    }
}

class PostReturnFieldsQuerableTestMockImpl
{
    use Querable, PostReturnFieldsQuerable;
}