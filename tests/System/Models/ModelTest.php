<?php declare(strict_types=1);
namespace System\Models;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(Model::class)]
#[CoversClass(Bindable::class)]
#[CoversClass(Rule::class)]
class ModelTest extends TestCase
{
    public function setUp(): void
    {
        require_once __DIR__ . '/../../../src/System/Core/Common.php';
    }

    public function test_bindField01(): void
    {
        $obj = new ModelTestMockA();
        $obj->bind([]);
        $this->assertEquals('abc', $obj->field_a);
        $this->assertEquals(0, $obj->field_b);
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
    #[Bindable]
    public string $field_a = 'abc';

    #[Bindable]
    public int $field_b = 0;

    public float $field_c;
}