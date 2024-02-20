<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use Attribute;
use Error;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Exception\ApplicationException;
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

    public function test_getClassAttribute_notSet(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\System\Model\TestClassAttribute" is not set to "Mvc4Wp\System\Model\TestMockAttributeTraitC"');
        TestClassAttribute::getClassAttribute(TestMockAttributeTraitC::class);
    }

    public function test_getClassAttribute_repeated(): void
    {
        $this->expectException(Error::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Attribute "Mvc4Wp\System\Model\TestClassAttribute" must not be repeated');
        TestClassAttribute::getClassAttribute(TestMockAttributeTraitD::class);
    }

    public function test_getPropertyAttribute01(): void
    {
        $attr = TestPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitA::class, 'test_a');
        $this->assertNotNull($attr);
        $this->assertEquals('A', $attr->field_a);
        $this->assertEquals('', $attr->field_b);
    }

    public function test_getPropertyAttribute02(): void
    {
        $attr = TestPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitA::class, 'test_b');
        $this->assertNotNull($attr);
        $this->assertEquals('AA', $attr->field_a);
        $this->assertEquals('BB', $attr->field_b);
    }

    public function test_getPropertyAttribute03(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Mvc4Wp\System\Model\TestPropertyAttribute: not set Mvc4Wp\System\Model\TestMockAttributeTraitB::test_a');
        TestPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitB::class, 'test_a');
    }

    public function test_getPropertyAttribute04(): void
    {
        $this->expectException(ApplicationException::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessage('Mvc4Wp\System\Model\TestPropertyAttribute: duplicate to set Mvc4Wp\System\Model\TestMockAttributeTraitB::test_b');
        TestPropertyAttribute::getPropertyAttribute(TestMockAttributeTraitB::class, 'test_b');
    }

    public function test_getPropertyAttributes01(): void
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
    use Cast, AttributeTrait;

    public function __construct(
        public string $field_a,
        public string $field_b = '',
    ) {
    }
}

#[Attribute(Attribute::TARGET_CLASS)]
class TestExtendsClassAttribute extends TestClassAttribute
{
    use Cast, AttributeTrait;

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
    use AttributeTrait;

    public function __construct(
        public string $field_a,
        public string $field_b = '',
    ) {
    }
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class TestPropertyAttributeOther
{
    use AttributeTrait;
}

#[Attribute(Attribute::TARGET_PROPERTY)]
class TestExtendedPropertyAttribute extends TestPropertyAttribute
{
    use AttributeTrait;

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
    use Cast;
    
    #[TestPropertyAttribute('A')]
    public string $test_a;

    #[TestPropertyAttribute('AA', 'BB')]
    public string $test_b;
}

#[TestClassAttribute(field_b: 'bb', field_a: 'aa')]
class TestMockAttributeTraitB
{
    use Cast;
    
    public string $test_a;

    #[TestPropertyAttribute('AA')]
    #[TestPropertyAttribute('AA')]
    public string $test_b;
}

class TestMockAttributeTraitC
{
    use Cast;
}

#[TestClassAttribute('')]
#[TestClassAttribute('')]
class TestMockAttributeTraitD
{

}

class TestMockAttributeTraitE
{
    use Cast;
    
    #[TestPropertyAttribute('a', 'b')]
    #[TestPropertyAttributeOther]
    public string $test_a;
}