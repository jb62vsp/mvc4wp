<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(Model::class)]
#[CoversClass(BindableField::class)]
class ModelTest extends TestCase
{
    public function test_bindField01(): void
    {
        $obj = new ModelTestMockA();
        $obj->bind([]);
        $this->assertEquals('abc', $obj->field_a);
        $this->assertFalse(isset($obj->field_b));
        $this->assertFalse(isset($obj->field_c));
    }

    public function test_bindField02(): void
    {
        $obj = new ModelTestMockA();
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
        $obj = new ModelTestMockA();
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

class ModelTestMockA extends Model
{
    #[BindableField(default_value: 'abc')]
    public string $field_a;

    #[BindableField]
    public int $field_b;

    public float $field_c;
}