<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Model\Attribute\Field;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(Bindable::class)]
class BindableTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function test_bind_noMatch(): void
    {
        $actual = new BindableTestTestMockA();
        $actual->bind([]);
        $this->assertEquals('abc', $actual->field_a);
        $this->assertEquals(0, $actual->field_b);
        $this->assertFalse(isset($actual->field_c));
    }

    public function test_bind_bindArray(): void
    {
        $actual = new BindableTestTestMockA();
        $actual->bind([
            'field_a' => 'def',
            'field_b' => 1,
            'field_c' => 2.3,
        ]);
        $this->assertEquals('def', $actual->field_a);
        $this->assertEquals(1, $actual->field_b);
        $this->assertFalse(isset($actual->field_c));
    }

    public function test_bind_bindObject(): void
    {
        $values = new stdClass();
        $values->field_a = 'def';
        $values->field_b = 1;
        $values->field_c = 2.3;

        $actual = new BindableTestTestMockA();
        $actual->bind($values);
        $this->assertEquals('def', $actual->field_a);
        $this->assertEquals(1, $actual->field_b);
        $this->assertFalse(isset($actual->field_c));
    }

    public function test_isBinded_true(): void
    {
        $actual = new BindableTestTestMockA();
        $actual->bind([
            'ID' => 1,
        ]);
        $this->assertTrue($actual->isBinded());
    }

    public function test_isBinded_false(): void
    {
        $actual = new BindableTestTestMockA();
        $this->assertFalse($actual->isBinded());
    }
}

class BindableTestTestMockA
{
    use Bindable;

    #[Field]
    public string $field_a = 'abc';

    #[Field]
    public int $field_b = 0;

    public float $field_c;

    public function setValue(string $property_name, mixed $mixed): void
    {
        $this->{$property_name} = $mixed;
    }
}