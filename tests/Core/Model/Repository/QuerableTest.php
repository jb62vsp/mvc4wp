<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Model;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Querable::class)]
class QuerableTest extends TestCase
{
    public function test_zero(): void
    {
        $obj = new QuerableTestMockA();

        $actual = $obj->getExpressions();
        $this->assertCount(0, $actual);
    }

    public function test_addExpression_singleString(): void
    {
        $obj = new QuerableTestMockA();

        $actual = $obj
            ->add('hoge', 'HOGE')
            ->getExpressions();
        $this->assertEquals(['hoge' => ['HOGE']], $actual);
    }

    public function test_addExpression_chainString(): void
    {
        $obj = new QuerableTestMockA();

        $actual = $obj
            ->add('hoge', ['HOGE', 'FUGA'])
            ->add('hoge', 'PIYO')
            ->getExpressions();
        $this->assertEquals(['hoge' => ['HOGE', 'FUGA', 'PIYO']], $actual);
    }

    public function test_addExpression_singleInt(): void
    {
        $obj = new QuerableTestMockA();

        $actual = $obj
            ->add('hoge', 1)
            ->getExpressions();
        $this->assertEquals(['hoge' => [1]], $actual);
    }

    public function test_addExpression_chainInt(): void
    {
        $obj = new QuerableTestMockA();

        $actual = $obj
            ->add('hoge', 1)
            ->add('hoge', [2, 3])
            ->getExpressions();
        $this->assertEquals(['hoge' => [1, 2, 3]], $actual);
    }

    public function test_addExpression_singleArray(): void
    {
        $obj = new QuerableTestMockA();

        $actual = $obj
            ->add('hoge', ['HOGE'])
            ->getExpressions();
        $this->assertEquals(['hoge' => ['HOGE']], $actual);
    }

    public function test_addExpression_multiArray(): void
    {
        $obj = new QuerableTestMockA();

        $actual = $obj
            ->add('hoge', ['HOGE'])
            ->add('hoge', ['FUGA', 'PIYO'])
            ->getExpressions();
        $this->assertEquals(['hoge' => ['HOGE', 'FUGA', 'PIYO']], $actual);
    }

    public function test_exists_false(): void
    {
        $obj = new QuerableTestMockA();

        $actual = $obj
            ->overrideExists('hoge');
        $this->assertFalse($actual);
    }

    public function test_exists_true(): void
    {
        $obj = new QuerableTestMockA();

        $actual = $obj
            ->add('hoge', 'HOGE')
            ->overrideExists('hoge');
        $this->assertTrue($actual);
    }
}

/**
 * @template T of Model
 */
class QuerableTestMockA
{
    /**
     * @use Querable<T>
     */
    use Querable;

    public function add(string $class, int|string|array $value): self
    {
        $this->addExpression($class, $value);
        return $this;
    }

    public function set(string $class, int|string|array $value): self
    {
        $this->setExpression($class, $value);
        return $this;
    }

    public function overrideExists(string $class): bool
    {
        return $this->exists($class);
    }
}