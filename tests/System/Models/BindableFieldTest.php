<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;

#[CoversClass(BindableField::class)]
class BindableFieldTest extends TestCase
{
    public function test_getAttributes01(): void
    {
        $prop1 = new ReflectionProperty(BindableFieldTestMockA::class, 'field_a');
        $this->assertEquals('string', $prop1->getType());
        $attrs1 = $prop1->getAttributes(BindableField::class);
        $this->assertCount(1, $attrs1);
        $this->assertInstanceOf(ReflectionAttribute::class, $attrs1[0]);
        $this->assertEquals('System\\Models\\BindableField', $attrs1[0]->getName());
        $this->assertEquals(Attribute::TARGET_PROPERTY, $attrs1[0]->getTarget());
        $this->assertCount(0, $attrs1[0]->getArguments());
    }

    public function test_getAttributes02(): void
    {
        $prop2 = new ReflectionProperty(BindableFieldTestMockA::class, 'field_b');
        $this->assertEquals('int', $prop2->getType()->getName());
        $attrs2 = $prop2->getAttributes(BindableField::class);
        $this->assertCount(1, $attrs2);
        $this->assertInstanceOf(ReflectionAttribute::class, $attrs2[0]);
        $this->assertEquals('System\\Models\\BindableField', $attrs2[0]->getName());
        $this->assertEquals(Attribute::TARGET_PROPERTY, $attrs2[0]->getTarget());
        $this->assertCount(1, $attrs2[0]->getArguments());
        $this->assertArrayHasKey('default_value', $attrs2[0]->getArguments());
        $this->assertEquals(0, $attrs2[0]->getArguments()['default_value']);
    }

    public function test_getAttributes03(): void
    {
        $prop3 = new ReflectionProperty(BindableFieldTestMockA::class, 'field_c');
        $this->assertEquals('float', $prop3->getType()->getName());
        $attrs3 = $prop3->getAttributes(BindableField::class);
        $this->assertCount(0, $attrs3);
    }

    public function test_getAttributesAllField01(): void
    {
        $refc = new ReflectionClass(BindableFieldTestMockA::class);
        $props = $refc->getProperties(ReflectionProperty::IS_PUBLIC);
        $this->assertCount(3, $props);
        $this->assertEquals('field_a', $props[0]->getName());
        $this->assertEquals('field_b', $props[1]->getName());
        $this->assertEquals('field_c', $props[2]->getName());

        $this->assertEquals('string', $props[0]->getType());
        $attrs1 = $props[0]->getAttributes(BindableField::class);
        $this->assertCount(1, $attrs1);
        $this->assertInstanceOf(ReflectionAttribute::class, $attrs1[0]);
        $this->assertEquals('System\\Models\\BindableField', $attrs1[0]->getName());
        $this->assertEquals(Attribute::TARGET_PROPERTY, $attrs1[0]->getTarget());
        $this->assertCount(0, $attrs1[0]->getArguments());

        $this->assertEquals('int', $props[1]->getType()->getName());
        $attrs2 = $props[1]->getAttributes(BindableField::class);
        $this->assertCount(1, $attrs2);
        $this->assertInstanceOf(ReflectionAttribute::class, $attrs2[0]);
        $this->assertEquals('System\\Models\\BindableField', $attrs2[0]->getName());
        $this->assertEquals(Attribute::TARGET_PROPERTY, $attrs2[0]->getTarget());
        $this->assertCount(1, $attrs2[0]->getArguments());
        $this->assertArrayHasKey('default_value', $attrs2[0]->getArguments());
        $this->assertEquals(0, $attrs2[0]->getArguments()['default_value']);

        $this->assertEquals('float', $props[2]->getType()->getName());
        $attrs3 = $props[2]->getAttributes(BindableField::class);
        $this->assertCount(0, $attrs3);
    }
}

class BindableFieldTestMockA
{
    #[BindableField]
    public string $field_a;

    #[BindableField(default_value: 0)]
    public int $field_b;

    public float $field_c;
}