<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use MessageFormatter;
use Mvc4Wp\Core\Language\MessagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MaxLengthRule::class)]
class MaxLengthRuleTest extends TestCase
{
    public function test_validate_valid(): void
    {
        $obj = new MaxLengthRule(5);

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(0, $actual);
    }

    public function test_validate_validSameLength(): void
    {
        $obj = new MaxLengthRule(4);

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(0, $actual);
    }

    public function test_validate_invalidLessOneLength(): void
    {
        $obj = new MaxLengthRule(3);

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('HOGE', $actual[0]->value);
        $this->assertInstanceOf(MaxLengthRule::class, $actual[0]->rule);
        $this->assertEquals(3, MaxLengthRule::cast($actual[0]->rule)->max);
        $this->assertEquals('hogeは、3文字以内で入力してください。', $actual[0]->rule->getMessage(new MaxLengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidChangeMessage(): void
    {
        $obj = new MaxLengthRule(2, 'foo.bar.buz');

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('HOGE', $actual[0]->value);
        $this->assertInstanceOf(MaxLengthRule::class, $actual[0]->rule);
        $this->assertEquals(2, MaxLengthRule::cast($actual[0]->rule)->max);
        $this->assertEquals('The hoge must be fall short of 2 characters.', $actual[0]->rule->getMessage(new MaxLengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_intValid(): void
    {
        $obj = new MaxLengthRule(2);

        $actual = $obj->validate('Hoge', 'hoge', 10);
        $this->assertCount(0, $actual);
    }

    public function test_validate_intInvalid(): void
    {
        $obj = new MaxLengthRule(1);

        $actual = $obj->validate('Hoge', 'hoge', 10);
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('10', $actual[0]->value);
        $this->assertInstanceOf(MaxLengthRule::class, $actual[0]->rule);
        $this->assertEquals(1, MaxLengthRule::cast($actual[0]->rule)->max);
        $this->assertEquals('hogeは、1文字以内で入力してください。', $actual[0]->rule->getMessage(new MaxLengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }
}

class MaxLengthRuleTestMessagerMock implements MessagerInterface
{
    public function message(string $message_key, array $args = []): string|false
    {
        return match ($message_key) {
            'validation.MaxLengthRule' => MessageFormatter::formatMessage('ja', '{field}は、{max}文字以内で入力してください。', $args),
            'foo.bar.buz' => MessageFormatter::formatMessage('ja', 'The {field} must be fall short of {max} characters.', $args),
        };
    }
}