<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Model\Attribute\Field;
use Mvc4Wp\Core\Model\Repository\QueryBuilderInterface;
use Mvc4Wp\Core\Model\Repository\QueryExecutorInterface;
use Mvc4Wp\Core\Model\Validator\Rule;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(Entity::class)]
#[CoversClass(Rule::class)]
class BindTraitTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function test_bindField01(): void
    {
        $obj = new BindTraitTestTestMockA();
        $obj->bind([]);
        $this->assertEquals('abc', $obj->field_a);
        $this->assertEquals(0, $obj->field_b);
        $this->assertFalse(isset($obj->field_c));
    }

    public function test_bindField02(): void
    {
        $obj = new BindTraitTestTestMockA();
        $obj->bind([
            'field_a' => 'def',
            'field_b' => 1,
            'field_c' => 2.3,
        ]);
        $this->assertEquals('def', $obj->field_a);
        $this->assertEquals(1, $obj->field_b);
        $this->assertFalse(isset($obj->field_c));
    }

    public function test_bindField03(): void
    {
        $obj = new BindTraitTestTestMockA();
        $values = new stdClass();
        $values->field_a = 'def';
        $values->field_b = 1;
        $values->field_c = 2.3;
        $obj->bind($values);
        $this->assertEquals('def', $obj->field_a);
        $this->assertEquals(1, $obj->field_b);
        $this->assertFalse(isset($obj->field_c));
    }
}

class BindTraitTestTestMockA extends Entity
{
    #[Field]
    public string $field_a = 'abc';

    #[Field]
    public int $field_b = 0;

    public float $field_c;

    public static function find(): QueryBuilderInterface
    {
        return new BindTraitTestMockQueryBuilder();
    }

    public function register(): int
    {
        return 0;
    }

    public function update(): void
    {
        // noop
    }

    public function delete(bool $force_delete = false): bool
    {
        return true;
    }
}

class BindTraitTestMockQueryBuilder implements QueryBuilderInterface
{
    public function build(): QueryExecutorInterface
    {
        return new BindTraitTestMockQueryExecutor();
    }
}

class BindTraitTestMockQueryExecutor implements QueryExecutorInterface
{
    public function get(): array
    {
        return [];
    }

    public function getSingle(): Entity|null
    {
        return null;
    }

    public function byID(int $id): Entity|null
    {
        return null;
    }

    public function count(): int
    {
        return 0;
    }
}