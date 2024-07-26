<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository\PostTaxonomy;

use BadMethodCallException;
use Mvc4Wp\Core\Model\Attribute\Entry;
use Mvc4Wp\Core\Model\CategoryEntity;
use Mvc4Wp\Core\Model\Repository\Querable;
use Mvc4Wp\Core\Model\Repository\QueryBuilderInterface;
use Mvc4Wp\Core\Model\Repository\TaxQueryFieldInQuery;
use Mvc4Wp\Core\Model\Repository\TaxQueryOperatorInQuery;
use Mvc4Wp\Core\Model\TermEntity;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PostTaxonomyQuerable::class)]
class PostTaxonomyQuerableTest extends TestCase
{
    public function test_by_single_default(): void
    {
        $obj = new PostTaxonomyQuerableTestMockImpl();

        $actual = $obj
            ->byTaxonomy('hoge', 'fuga')
            ->getExpressions();
        $this->assertEquals([
            TaxQueryExpr::class => [
                ['hoge', 'term_id', 'fuga', true, 'IN'],
            ],
        ], $actual);
    }

    public function test_by_single(): void
    {
        $obj = new PostTaxonomyQuerableTestMockImpl();

        $actual = $obj
            ->byTaxonomy('hoge', 'fuga', TaxQueryFieldInQuery::SLUG, TaxQueryOperatorInQuery::AND , false)
            ->getExpressions();
        $this->assertEquals([
            TaxQueryExpr::class => [
                ['hoge', 'slug', 'fuga', false, 'AND'],
            ],
        ], $actual);
    }

    public function test_by_chain(): void
    {
        $obj = new PostTaxonomyQuerableTestMockImpl();

        $actual = $obj
            ->byTaxonomy('hoge', 'fuga')
            ->byTaxonomy('hoge', 'fuga', TaxQueryFieldInQuery::SLUG, TaxQueryOperatorInQuery::AND , false)
            ->getExpressions();
        $this->assertEquals([
            TaxQueryExpr::class => [
                ['hoge', 'term_id', 'fuga', true, 'IN'],
                ['hoge', 'slug', 'fuga', false, 'AND'],
            ],
        ], $actual);
    }

    public function test_by_entity(): void
    {
        $obj = new PostTaxonomyQuerableTestMockImpl();

        $term = new PostTaxonomyQuerableTestTermEntityMockImpl();

        $actual = $obj
            ->byTerm($term)
            ->getExpressions();
        $this->assertEquals([
            TaxQueryExpr::class => [
                ['test', 'term_id', 1, true, 'IN'],
            ],
        ], $actual);
    }
}


class PostTaxonomyQuerableTestMockImpl
{
    use Querable, PostTaxonomyQuerable;
}

class PostTaxonomyQuerableTestTermEntityMockImpl extends TermEntity
{
    public readonly int $term_id;

    public function __construct()
    {
        $this->term_id = 1;
        $this->taxonomy = 'test';
    }

    public static function find(): QueryBuilderInterface
    {
        throw new BadMethodCallException();
    }

    public function register(): int
    {
        throw new BadMethodCallException();
    }

    public function update(): void
    {
        throw new BadMethodCallException();
    }

    public function delete(bool $force_delete = false): bool
    {
        throw new BadMethodCallException();
    }
}