<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Model\Repository\QueryInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;
use Mvc4Wp\Core\Model\Validator\Rule;
use Mvc4Wp\Core\Model\Attribute\Field;

#[CoversClass(Model::class)]
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

class BindTraitTestTestMockA extends Model
{
    #[Field]
    public string $field_a = 'abc';

    #[Field]
    public int $field_b = 0;

    public float $field_c;

    public static function find(): QueryInterface
    {
        return new ModelTestMockQuery();
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

class ModelTestMockQuery implements QueryInterface
{
    public function search(string $key, string $value, string $compare = '=', string $type = 'CHAR'): QueryInterface
    {
        return $this;
    }

    public function order(string $order_by, string $order = 'ASC', string $type = 'CHAR'): QueryInterface
    {
        return $this;
    }

    public function get(): array
    {
        return [];
    }

    public function getSingle(): ?Model
    {
        return null;
    }

    public function byID(int $id): ?Model
    {
        return null;
    }

    public function count(): int
    {
        return 0;
    }
}