<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use Attribute;
use Error;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Exception\ApplicationException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AttributeTrait::class)]
class AttributeTraitTest extends TestCase
{
    public function test_getClassAttribute_withDefaultValue(): void
    {
        $attr = AttributeTraitTestClassAttributeA::getClassAttribute(AttributeTraitTestMockA::class);
        $this->assertNotNull($attr);
        $this->assertEquals('a', $attr->field_a);
        $this->assertEquals('b', $attr->field_b);
    }

    public function test_getClassAttribute_withoutDefaultValue(): void
    {
        $attr = AttributeTraitTestClassAttributeA::getClassAttribute(AttributeTraitTestMockB::class);
        $this->assertNotNull($attr);
        $this->assertEquals('aa', $attr->field_a);
        $this->assertEquals('bb', $attr->field_b);
    }

    public function test_getClassAttribute_extended(): void
    {
        $attr = AttributeTraitTestClassAttributeA::getClassAttribute(AttributeTraitTestMockE::class);
        $this->assertNotNull($attr);
        $this->assertEquals('a', $attr->field_a);
        $this->assertEquals('b', $attr->field_b);
    }

    public function test_getClassAttribute_dontUpcast(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestClassAttributeB" is not set to "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestMockA"');
        AttributeTraitTestClassAttributeB::getClassAttribute(AttributeTraitTestMockA::class);
    }

    public function test_getClassAttribute_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestClassAttributeA" is not set to "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestMockC"');
        AttributeTraitTestClassAttributeA::getClassAttribute(AttributeTraitTestMockC::class);
    }

    public function test_getClassAttribute_repeated(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestClassAttributeA" must not be repeated');
        AttributeTraitTestClassAttributeA::getClassAttribute(AttributeTraitTestMockD::class);
    }

    public function test_getPropertyAttribute_withDefaultValue(): void
    {
        $attr = AttributeTraitTestPropertyAttributeA::getPropertyAttribute(AttributeTraitTestMockA::class, 'test_a');
        $this->assertNotNull($attr);
        $this->assertEquals('A', $attr->field_a);
        $this->assertEquals('', $attr->field_b);
    }

    public function test_getPropertyAttribute_withoutDefaultValue(): void
    {
        $attr = AttributeTraitTestPropertyAttributeA::getPropertyAttribute(AttributeTraitTestMockA::class, 'test_b');
        $this->assertNotNull($attr);
        $this->assertEquals('AA', $attr->field_a);
        $this->assertEquals('BB', $attr->field_b);
    }

    public function test_getPropertyAttribute_extended(): void
    {
        $attr = AttributeTraitTestPropertyAttributeC::getPropertyAttribute(AttributeTraitTestMockE::class, 'test_b');
        $this->assertNotNull($attr);
        $this->assertEquals('a', $attr->field_a);
        $this->assertEquals('b', $attr->field_b);
    }

    public function test_getPropertyAttribute_dontUpcast(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestPropertyAttributeC" is not set to "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestMockA::test_a"');
        AttributeTraitTestPropertyAttributeC::getPropertyAttribute(AttributeTraitTestMockA::class, 'test_a');
    }

    public function test_getPropertyAttribute_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestPropertyAttributeA" is not set to "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestMockB::test_a"');
        AttributeTraitTestPropertyAttributeA::getPropertyAttribute(AttributeTraitTestMockB::class, 'test_a');
    }

    public function test_getPropertyAttribute_repeated(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\AttributeTraitTestPropertyAttributeA" must not be repeated');
        AttributeTraitTestPropertyAttributeA::getPropertyAttribute(AttributeTraitTestMockB::class, 'test_b');
    }

    public function test_getPropertyAttributes(): void
    {
        $attrs = AttributeTraitTestPropertyAttributeA::getPropertyAttributes(AttributeTraitTestMockE::class, 'test_a');
        $this->assertCount(1, $attrs);
        $this->assertEquals('a', $attrs[0]->field_a);
        $this->assertEquals('b', $attrs[0]->field_b);
    }

    public function test_getPropertyAttributes_withoutDefaultValue(): void
    {
        $attrs = AttributeTraitTestPropertyAttributeA::getPropertyAttributes(AttributeTraitTestMockE::class, 'test_a');
        $this->assertCount(1, $attrs);
        $this->assertEquals('a', $attrs[0]->field_a);
        $this->assertEquals('b', $attrs[0]->field_b);
    }

    public function test_getPropertyAllAttributes_noAttrs():void {
        $actual = AttributeTraitTestPropertyAttributeD::getPropertyAllAttributes(AttributeTraitTestMockF::class, 'test_a');
        $this->assertCount(0, $actual);
    }

    public function test_getPropertyAllAttributes_singleAttr():void {
        $actual = AttributeTraitTestPropertyAttributeD::getPropertyAllAttributes(AttributeTraitTestMockF::class, 'test_b');
        $this->assertCount(1, $actual);
    }

    public function test_getPropertyAllAttributes_multiAttrs():void {
        $actual = AttributeTraitTestPropertyAttributeD::getPropertyAllAttributes(AttributeTraitTestMockF::class, 'test_c');
        $this->assertCount(3, $actual);
    }
}

#[Attribute(Attribute::TARGET_CLASS)]
class AttributeTraitTestClassAttributeA
{
    use Castable, AttributeTrait;

    public function __construct(
        public string $field_a,
        public string $field_b = '',
    ) {
    }
}

#[Attribute(Attribute::TARGET_CLASS)]
class AttributeTraitTestClassAttributeB extends AttributeTraitTestClassAttributeA
{
    use Castable, AttributeTrait;

    public function __construct(
        string $field_a,
        string $field_b,
        public string $field_c = '',
    ) {
        parent::__construct($field_a, $field_b);
    }
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class AttributeTraitTestPropertyAttributeA
{
    use Castable, AttributeTrait;

    public function __construct(
        public string $field_a,
        public string $field_b = '',
    ) {
    }
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class AttributeTraitTestPropertyAttributeB
{
    use Castable, AttributeTrait;
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class AttributeTraitTestPropertyAttributeC extends AttributeTraitTestPropertyAttributeA
{
    use Castable, AttributeTrait;

    public function __construct(
        string $field_a,
        string $field_b,
        public string $field_c = '',
    ) {
        parent::__construct($field_a, $field_b);
    }
}

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class AttributeTraitTestPropertyAttributeD
{
    use Castable, AttributeTrait;
}

#[AttributeTraitTestClassAttributeA('a', 'b')]
class AttributeTraitTestMockA
{
    use Castable;

    #[AttributeTraitTestPropertyAttributeA('A')]
    public string $test_a;

    #[AttributeTraitTestPropertyAttributeA('AA', 'BB')]
    public string $test_b;
}

#[AttributeTraitTestClassAttributeA(field_b: 'bb', field_a: 'aa')]
class AttributeTraitTestMockB
{
    use Castable;

    public string $test_a;

    #[AttributeTraitTestPropertyAttributeA('AA')]
    #[AttributeTraitTestPropertyAttributeA('AA')]
    public string $test_b;
}

class AttributeTraitTestMockC
{
    use Castable;
}

#[AttributeTraitTestClassAttributeA('')]
#[AttributeTraitTestClassAttributeA('')]
class AttributeTraitTestMockD
{

}

#[AttributeTraitTestClassAttributeB('a', 'b')]
class AttributeTraitTestMockE
{
    use Castable;

    #[AttributeTraitTestPropertyAttributeA('a', 'b')]
    #[AttributeTraitTestPropertyAttributeB]
    public string $test_a;

    #[AttributeTraitTestPropertyAttributeC('a', 'b')]
    public string $test_b;
}

class AttributeTraitTestMockF
{
    use Castable;

    public string $test_a;

    #[AttributeTraitTestPropertyAttributeD]
    public string $test_b;

    #[AttributeTraitTestPropertyAttributeD]
    #[AttributeTraitTestPropertyAttributeD]
    #[AttributeTraitTestPropertyAttributeD]
    public string $test_c;
}