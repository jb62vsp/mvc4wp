<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\Term;

use Mvc4Wp\Core\Model\Attribute\Entry;
use Mvc4Wp\Core\Model\CategoryEntity;
use Mvc4Wp\Core\Model\Repository\Querable;
use Mvc4Wp\Core\Model\TagEntity;
use Mvc4Wp\Core\Model\TermEntity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(TermQuerable::class)]
class TermQuerableTest extends TestCase
{
    public function test_asEntity_single_singleParam(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asEntity(TermQuerableTestCustomCategoryEntity::class)
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['custom_category']], $actual);
    }

    public function test_asEntity_single_multiParams(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asEntity(TermQuerableTestCustomCategoryEntity::class, TermQuerableTestCustomTagEntity::class)
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['custom_category', 'custom_tag']], $actual);
    }

    public function test_asEntity_chain(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asEntity(TermQuerableTestCustomCategoryEntity::class)
            ->asEntity(TermQuerableTestCustomTagEntity::class)
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['custom_category', 'custom_tag']], $actual);
    }

    public function test_asEntity_chain_withNoExtends(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asEntity(TermQuerableTestCustomCategoryEntity::class)
            ->asEntity(TermQuerableTestCustomTagEntity::class)
            ->asEntity(TermQuerableTestNoExtendsEntity::class)
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['custom_category', 'custom_tag']], $actual);
    }

    public function test_asCategory_single(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asCategory()
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['category']], $actual);
    }

    public function test_asCategory_single_withParam(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asCategory('hoge')
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['hoge']], $actual);
    }

    public function test_asCategory_chain(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asCategory()
            ->asCategory('hoge')
            ->asCategory('fuga')
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['category', 'hoge', 'fuga']], $actual);
    }

    public function test_asTag_single(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asTag()
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['post_tag']], $actual);
    }

    public function test_asTag_single_withParam(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asTag('hoge')
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['hoge']], $actual);
    }

    public function test_asTag_chain(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->asTag()
            ->asTag('hoge')
            ->asTag('fuga')
            ->getExpressions();
        $this->assertEquals([TermTaxonomyExpr::class => ['post_tag', 'hoge', 'fuga']], $actual);
    }

    public function test_byName_single(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->byName('hoge')
            ->getExpressions();
        $this->assertEquals([TermNameExpr::class => ['hoge']], $actual);
    }

    public function test_byName_chain(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->byName('hoge')
            ->byName('fuga')
            ->byName('piyo')
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([TermNameExpr::class => ['piyo']], $actual);
    }

    public function test_bySlug_single(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->bySlug('hoge')
            ->getExpressions();
        $this->assertEquals([TermSlugExpr::class => ['hoge']], $actual);
    }

    public function test_bySlug_chain(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->bySlug('hoge')
            ->bySlug('fuga')
            ->bySlug('piyo')
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([TermSlugExpr::class => ['piyo']], $actual);
    }

    public function test_byPostID_single(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->byPostID(1)
            ->getExpressions();
        $this->assertEquals([TermObjectIDExpr::class => [1]], $actual);
    }

    public function test_byPostID_chain(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->byPostID(1)
            ->byPostID(2)
            ->byPostID(3)
            ->getExpressions();
        $this->assertCount(1, $actual);
        $this->assertEquals([TermObjectIDExpr::class => [3]], $actual);
    }

    public function test_showEmpty(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->showEmpty()
            ->getExpressions();
        $this->assertEquals([TermHideEmptyExpr::class => [0]], $actual);
    }

    public function test_hideEmpty(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->hideEmpty()
            ->getExpressions();
        $this->assertEquals([TermHideEmptyExpr::class => [1]], $actual);
    }

    public function test_showEmpty_chain(): void
    {
        $obj = new TermQuerableTestMockImpl();

        $actual = $obj
            ->hideEmpty()
            ->showEmpty()
            ->getExpressions();
        $this->assertEquals([TermHideEmptyExpr::class => [0]], $actual);
    }
}

class TermQuerableTestMockImpl
{
    use Querable, TermQuerable;
}

#[Entry(name: 'custom_category')]
class TermQuerableTestCustomCategoryEntity extends CategoryEntity
{
}

#[Entry(name: 'custom_tag')]
class TermQuerableTestCustomTagEntity extends TagEntity
{
}

#[Entry(name: 'noextends')]
class TermQuerableTestNoExtendsEntity
{
}