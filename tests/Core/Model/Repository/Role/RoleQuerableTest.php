<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Role;

use Mvc4Wp\Core\Model\Repository\Querable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RoleQuerable::class)]
class RoleQuerableTest extends TestCase
{
    public function test_byRole_single(): void
    {
        $obj = new RoleQuerableTestMockImpl();

        $actual = $obj
            ->byRole('hoge')
            ->getExpressions();
        $this->assertEquals([RoleExpr::class => ['hoge']], $actual);
    }

    public function test_byRole_chain(): void
    {
        $obj = new RoleQuerableTestMockImpl();

        $actual = $obj
            ->byRole('hoge')
            ->byRole('fuga')
            ->byRole('piyo')
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([RoleExpr::class => ['piyo']], $actual);
    }
}

class RoleQuerableTestMockImpl
{
    use Querable, RoleQuerable;
}