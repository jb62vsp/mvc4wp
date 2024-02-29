<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use MessageFormatter;
use Mvc4Wp\Core\Language\MessagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(LengthRule::class)]
class LengthRuleTest extends TestCase
{
    public function test_validate_valid(): void
    {
        $obj = new LengthRule(0, 10);

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(0, $actual);
    }

    public function test_validate_validSameLength(): void
    {
        $obj = new LengthRule(4, 4);

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(0, $actual);
    }

    public function test_validate_invalidMoreOneLength(): void
    {
        $obj = new LengthRule(5, 10);

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('HOGE', $actual[0]->value);
        $this->assertInstanceOf(LengthRule::class, $actual[0]->rule);
        $this->assertEquals(5, LengthRule::cast($actual[0]->rule)->minimum);
        $this->assertEquals(10, LengthRule::cast($actual[0]->rule)->max);
        $this->assertEquals('hogeは、5文字以上、10文字以内で入力してください。', $actual[0]->rule->getMessage(new LengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidLessOneLength(): void
    {
        $obj = new LengthRule(2, 3);

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('HOGE', $actual[0]->value);
        $this->assertInstanceOf(LengthRule::class, $actual[0]->rule);
        $this->assertEquals(2, LengthRule::cast($actual[0]->rule)->minimum);
        $this->assertEquals(3, LengthRule::cast($actual[0]->rule)->max);
        $this->assertEquals('hogeは、2文字以上、3文字以内で入力してください。', $actual[0]->rule->getMessage(new LengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidChangeMessage(): void
    {
        $obj = new LengthRule(10, 15, 'foo.bar.buz');

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('HOGE', $actual[0]->value);
        $this->assertInstanceOf(LengthRule::class, $actual[0]->rule);
        $this->assertEquals(10, LengthRule::cast($actual[0]->rule)->minimum);
        $this->assertEquals(15, LengthRule::cast($actual[0]->rule)->max);
        $this->assertEquals('The hoge must be within 10 to 15 characters.', $actual[0]->rule->getMessage(new LengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_intValid(): void
    {
        $obj = new LengthRule(2, 2);

        $actual = $obj->validate('Hoge', 'hoge', 10);
        $this->assertCount(0, $actual);
    }

    public function test_validate_intInvalid(): void
    {
        $obj = new LengthRule(3, 4);

        $actual = $obj->validate('Hoge', 'hoge', 10);
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('10', $actual[0]->value);
        $this->assertInstanceOf(LengthRule::class, $actual[0]->rule);
        $this->assertEquals(3, LengthRule::cast($actual[0]->rule)->minimum);
        $this->assertEquals(4, LengthRule::cast($actual[0]->rule)->max);
        $this->assertEquals('hogeは、3文字以上、4文字以内で入力してください。', $actual[0]->rule->getMessage(new LengthRuleTestMessagerMock(), ['field' => 'hoge']));
    }
}

class LengthRuleTestMessagerMock implements MessagerInterface
{
    public function message(string $message_key, array $args = []): string
    {
        return match ($message_key) {
            'validation.LengthRule' => MessageFormatter::formatMessage('ja', '{field}は、{minimum}文字以上、{max}文字以内で入力してください。', $args),
            'foo.bar.buz' => MessageFormatter::formatMessage('ja', 'The {field} must be within {minimum} to {max} characters.', $args),
        };
    }
}