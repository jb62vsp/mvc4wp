<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use MessageFormatter;
use Mvc4Wp\Core\Language\MessagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MinLengthRule::class)]
class MinLengthRuleTest extends TestCase
{
    public function test_validate_valid(): void
    {
        $obj = new MinLengthRule();

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(0, $actual);
    }

    public function test_validate_validSameLength(): void
    {
        $obj = new MinLengthRule(4);

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(0, $actual);
    }

    public function test_validate_invalidMoreOneLength(): void
    {
        $obj = new MinLengthRule(5);

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('HOGE', $actual[0]->value);
        $this->assertInstanceOf(MinLengthRule::class, $actual[0]->rule);
        $this->assertEquals(5, MinLengthRule::cast($actual[0]->rule)->minimum);
        $this->assertEquals('hogeには、5文字以上の入力が必要です。："HOGE"', $actual[0]->rule->getMessage(new MinLengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidChangeMessage(): void
    {
        $obj = new MinLengthRule(10, 'foo.bar.buz');

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('HOGE', $actual[0]->value);
        $this->assertInstanceOf(MinLengthRule::class, $actual[0]->rule);
        $this->assertEquals(10, MinLengthRule::cast($actual[0]->rule)->minimum);
        $this->assertEquals('The hoge field must be at least 10 characters in length. : "HOGE"', $actual[0]->rule->getMessage(new MinLengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_intValid(): void
    {
        $obj = new MinLengthRule(2);

        $actual = $obj->validate('Hoge', 'hoge', 10);
        $this->assertCount(0, $actual);
    }

    public function test_validate_intInvalid(): void
    {
        $obj = new MinLengthRule(3);

        $actual = $obj->validate('Hoge', 'hoge', 10);
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('10', $actual[0]->value);
        $this->assertInstanceOf(MinLengthRule::class, $actual[0]->rule);
        $this->assertEquals(3, MinLengthRule::cast($actual[0]->rule)->minimum);
        $this->assertEquals('hogeには、3文字以上の入力が必要です。："10"', $actual[0]->rule->getMessage(new MinLengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }
}

class MinLengthRuleTestMessagerMock implements MessagerInterface
{
    public function message(string $message_key, array $args = []): string|false
    {
        return match ($message_key) {
            'validation.MinLengthRule' => MessageFormatter::formatMessage('ja', '{field}には、{minimum}文字以上の入力が必要です。："{value}"', $args),
            'foo.bar.buz' => MessageFormatter::formatMessage('ja', 'The {field} field must be at least {minimum} characters in length. : "{value}"', $args),
        };
    }
}