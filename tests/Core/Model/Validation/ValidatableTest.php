<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use Attribute;
use Mvc4Wp\Core\Model\Attribute\AttributeTrait;
use Mvc4Wp\Core\Model\Validatable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Validatable::class)]
class ValidatableTest extends TestCase
{
    public function test_validate_valid(): void
    {
        $obj = new ValidatableTestMockA();

        $actual = $obj->validate([
            'noMessage' => 'OK'
        ]);
        $this->assertCount(0, $actual);
    }

    public function test_validate_invalidSingleValue(): void
    {
        $obj = new ValidatableTestMockB();

        $actual = $obj->validate([
            'noMessage' => 'NG'
        ]);
        $this->assertCount(1, $actual);
        $this->assertArrayHasKey('noMessage', $actual);
        $this->assertIsArray($actual['noMessage']);
        $this->assertCount(1, $actual['noMessage']);
        $this->assertEquals(ValidatableTestMockB::class, $actual['noMessage'][0]->class_name);
        $this->assertEquals('noMessage', $actual['noMessage'][0]->property_name);
        $this->assertEquals('NG', $actual['noMessage'][0]->value);
        $this->assertEquals('', $actual['noMessage'][0]->rule->getMessage());
    }

    public function test_validate_invalidMultiValue(): void
    {
        $obj = new ValidatableTestMockB();

        $actual = $obj->validate([
            'noMessage' => 'NG',
            'messaged' => 'NG',
        ]);
        $this->assertCount(2, $actual);
        $this->assertArrayHasKey('noMessage', $actual);
        $this->assertIsArray($actual['noMessage']);
        $this->assertCount(1, $actual['noMessage']);
        $this->assertEquals(ValidatableTestMockB::class, $actual['noMessage'][0]->class_name);
        $this->assertEquals('noMessage', $actual['noMessage'][0]->property_name);
        $this->assertEquals('NG', $actual['noMessage'][0]->value);
        $this->assertEquals('', $actual['noMessage'][0]->rule->getMessage());
        $this->assertArrayHasKey('messaged', $actual);
        $this->assertIsArray($actual['messaged']);
        $this->assertCount(1, $actual['messaged']);
        $this->assertEquals(ValidatableTestMockB::class, $actual['messaged'][0]->class_name);
        $this->assertEquals('messaged', $actual['messaged'][0]->property_name);
        $this->assertEquals('NG', $actual['messaged'][0]->value);
        $this->assertEquals('hoge', $actual['messaged'][0]->rule->getMessage());
    }

    public function test_validate_invalidMultiValueMultiError(): void
    {
        $obj = new ValidatableTestMockC();

        $actual = $obj->validate([
            'noMessage' => 'NG',
            'messaged' => 'NG',
        ]);
        $this->assertCount(2, $actual);
        $this->assertArrayHasKey('noMessage', $actual);
        $this->assertIsArray($actual['noMessage']);
        $this->assertCount(1, $actual['noMessage']);
        $this->assertEquals(ValidatableTestMockC::class, $actual['noMessage'][0]->class_name);
        $this->assertEquals('noMessage', $actual['noMessage'][0]->property_name);
        $this->assertEquals('NG', $actual['noMessage'][0]->value);
        $this->assertEquals('', $actual['noMessage'][0]->rule->getMessage());
        $this->assertArrayHasKey('messaged', $actual);
        $this->assertIsArray($actual['messaged']);
        $this->assertCount(2, $actual['messaged']);
        $this->assertEquals(ValidatableTestMockC::class, $actual['messaged'][0]->class_name);
        $this->assertEquals('messaged', $actual['messaged'][0]->property_name);
        $this->assertEquals('NG', $actual['messaged'][0]->value);
        $this->assertEquals('hoge', $actual['messaged'][0]->rule->getMessage());
        $this->assertEquals(ValidatableTestMockC::class, $actual['messaged'][1]->class_name);
        $this->assertEquals('messaged', $actual['messaged'][1]->property_name);
        $this->assertEquals('NG', $actual['messaged'][1]->value);
        $this->assertEquals('fuga', $actual['messaged'][1]->rule->getMessage());
    }
}

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class ValidatableTestMockRuleValid extends Rule
{
    use AttributeTrait;

    public function __construct(
        public string $message = '',
    ) {
    }

    public function validate(string $class_name, string $property_name, mixed $value): array
    {
        return [];
    }

    public function getMessage(array $args = []): string
    {
        return $this->message;
    }
}

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class ValidatableTestMockRuleInvalidA extends Rule
{
    use AttributeTrait;

    public function __construct(
        public string $message = '',
    ) {
    }

    public function validate(string $class_name, string $property_name, mixed $value): array
    {
        $result = [];

        $result[] = new ValidationError($class_name, $property_name, strval($value), $this);

        return $result;
    }

    public function getMessage(array $args = []): string
    {
        return $this->message;
    }
}

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class ValidatableTestMockRuleInvalidB extends Rule
{
    use AttributeTrait;

    public function __construct(
        public string $message = '',
    ) {
    }

    public function validate(string $class_name, string $property_name, mixed $value): array
    {
        $result = [];

        $result[] = new ValidationError($class_name, $property_name, strval($value), $this);

        return $result;
    }

    public function getMessage(array $args = []): string
    {
        return $this->message;
    }
}

class ValidatableTestMockA
{
    use Validatable;

    #[ValidatableTestMockRuleValid]
    public string $noMessage;

    #[ValidatableTestMockRuleValid(message: 'error')]
    public string $messaged;
}

class ValidatableTestMockB
{
    use Validatable;

    #[ValidatableTestMockRuleInvalidA]
    public string $noMessage;

    #[ValidatableTestMockRuleInvalidA(message: 'hoge')]
    public string $messaged;
}

class ValidatableTestMockC
{
    use Validatable;

    #[ValidatableTestMockRuleInvalidA]
    public string $noMessage;

    #[ValidatableTestMockRuleInvalidA(message: 'hoge')]
    #[ValidatableTestMockRuleInvalidB(message: 'fuga')]
    public string $messaged;
}