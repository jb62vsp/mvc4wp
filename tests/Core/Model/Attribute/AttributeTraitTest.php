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
        $attr = TestClassAttribute::getClassAttribute(TestMockAttributeTraitA::class);
        $this->assertNotNull($attr);
        $this->assertEquals('a', $attr->field_a);
        $this->assertEquals('b', $attr->field_b);
    }

    public function test_getClassAttribute_withoutDefaultValue(): void
    {
        $attr = TestClassAttribute::getClassAttribute(TestMockAttributeTraitB::class);
        $this->assertNotNull($attr);
        $this->assertEquals('aa', $attr->field_a);
        $this->assertEquals('bb', $attr->field_b);
    }

    public function test_getClassAttribute_extended(): void
    {
        $attr = TestClassAttribute::getClassAttribute(TestMockAttributeTraitE::class);
        $this->assertNotNull($attr);
        $this->assertEquals('a', $attr->field_a);
        $this->assertEquals('b', $attr->field_b);
    }

    public function test_getClassAttribute_dontUpcast(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\TestExtendedClassAttribute" is not set to "Mvc4Wp\Core\Model\Attribute\TestMockAttributeTraitA"');
        TestExtendedClassAttribute::getClassAttribute(TestMockAttributeTraitA::class);
    }

    public function test_getClassAttribute_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\TestClassAttribute" is not set to "Mvc4Wp\Core\Model\Attribute\TestMockAttributeTraitC"');
        TestClassAttribute::getClassAttribute(TestMockAttributeTraitC::class);
    }

    public function test_getClassAttribute_repeated(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\TestClassAttribute" must not be repeated');
        TestClassAttribute::getClassAttribute(TestMockAttributeTraitD::class);
    }

    public function test_getPropertyAttribute_withDefaultValue(): void
    {
        $attr = TestPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitA::class, 'test_a');
        $this->assertNotNull($attr);
        $this->assertEquals('A', $attr->field_a);
        $this->assertEquals('', $attr->field_b);
    }

    public function test_getPropertyAttribute_withoutDefaultValue(): void
    {
        $attr = TestPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitA::class, 'test_b');
        $this->assertNotNull($attr);
        $this->assertEquals('AA', $attr->field_a);
        $this->assertEquals('BB', $attr->field_b);
    }

    public function test_getPropertyAttribute_extended(): void
    {
        $attr = TestExtendedPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitE::class, 'test_b');
        $this->assertNotNull($attr);
        $this->assertEquals('a', $attr->field_a);
        $this->assertEquals('b', $attr->field_b);
    }

    public function test_getPropertyAttribute_dontUpcast(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\TestExtendedPropertyAttribute" is not set to "Mvc4Wp\Core\Model\Attribute\TestMockAttributeTraitA::test_a"');
        TestExtendedPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitA::class, 'test_a');
    }

    public function test_getPropertyAttribute_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\TestPropertyAttribute" is not set to "Mvc4Wp\Core\Model\Attribute\TestMockAttributeTraitB::test_a"');
        TestPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitB::class, 'test_a');
    }

    public function test_getPropertyAttribute_repeated(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\Core\Model\Attribute\TestPropertyAttribute" must not be repeated');
        TestPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitB::class, 'test_b');
    }

    public function test_getPropertyAttributes(): void
    {
        $attrs = TestPropertyAttribute::getPropertyAttributes(TestMockAttributeTraitE::class, 'test_a');
        $this->assertCount(1, $attrs);
        $this->assertEquals('a', $attrs[0]->field_a);
        $this->assertEquals('b', $attrs[0]->field_b);
    }

    public function test_getPropertyAttributes_withoutDefaultValue(): void
    {
        $attrs = TestPropertyAttribute::getPropertyAttributes(TestMockAttributeTraitE::class, 'test_a');
        $this->assertCount(1, $attrs);
        $this->assertEquals('a', $attrs[0]->field_a);
        $this->assertEquals('b', $attrs[0]->field_b);
    }
}

#[Attribute(Attribute::TARGET_CLASS)]
class TestClassAttribute
{
    use Castable, AttributeTrait;

    public function __construct(
        public string $field_a,
        public string $field_b = '',
    ) {
    }
}

#[Attribute(Attribute::TARGET_CLASS)]
class TestExtendedClassAttribute extends TestClassAttribute
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
class TestPropertyAttribute
{
    use Castable, AttributeTrait;

    public function __construct(
        public string $field_a,
        public string $field_b = '',
    ) {
    }
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class TestPropertyAttributeOther
{
    use Castable, AttributeTrait;
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class TestExtendedPropertyAttribute extends TestPropertyAttribute
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

#[TestClassAttribute('a', 'b')]
class TestMockAttributeTraitA
{
    use Castable;

    #[TestPropertyAttribute('A')]
    public string $test_a;

    #[TestPropertyAttribute('AA', 'BB')]
    public string $test_b;
}

#[TestClassAttribute(field_b: 'bb', field_a: 'aa')]
class TestMockAttributeTraitB
{
    use Castable;

    public string $test_a;

    #[TestPropertyAttribute('AA')]
    #[TestPropertyAttribute('AA')]
    public string $test_b;
}

class TestMockAttributeTraitC
{
    use Castable;
}

#[TestClassAttribute('')]
#[TestClassAttribute('')]
class TestMockAttributeTraitD
{

}

#[TestExtendedClassAttribute('a', 'b')]
class TestMockAttributeTraitE
{
    use Castable;

    #[TestPropertyAttribute('a', 'b')]
    #[TestPropertyAttributeOther]
    public string $test_a;

    #[TestExtendedPropertyAttribute('a', 'b')]
    public string $test_b;
}