<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Model::class)]
class ModelTest extends TestCase
{
    public function test_bindField01(): void
    {
        $obj = new ModelTestMockA();
        $obj->bindMe([]);
        $this->assertEquals('abc', $obj->field_a);
        $this->assertFalse(isset($obj->field_b));
        $this->assertFalse(isset($obj->field_c));
    }

    public function test_bindField02(): void
    {
        $obj = new ModelTestMockA();
        $obj->bindMe([
            'field_a' => 'def',
            'field_b' => 1,
            'field_c' => 2.3,
        ]);
        $this->assertEquals('def', $obj->field_a);
        $this->assertEquals(1, $obj->field_b);
        $this->assertEquals(2.3, $obj->field_c);
    }
}

class ModelTestMockA extends Model
{
    #[BindableField(default_value: 'abc')]
    public string $field_a;

    #[BindableField]
    public int $field_b;

    public float $field_c;

    public function bindMe(object|array $data): void
    {
        $this->bind($data);
    }
}