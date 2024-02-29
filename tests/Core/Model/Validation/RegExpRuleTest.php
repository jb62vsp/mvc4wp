<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use MessageFormatter;
use Mvc4Wp\Core\Language\MessagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RegExpRule::class)]
class RegExpRuleTest extends TestCase
{
    public function test_validate_valid(): void
    {
        $obj = new RegExpRule(CommonPattern::INTEGER);

        $actual = $obj->validate('Hoge', 'hoge', '-123');
        $this->assertCount(0, $actual);
    }

    public function test_validate_invalidIncorrectInt(): void
    {
        $obj = new RegExpRule(CommonPattern::INTEGER);

        $actual = $obj->validate('Hoge', 'hoge', '-123a');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('-123a', $actual[0]->value);
        $this->assertInstanceOf(RegExpRule::class, $actual[0]->rule);
        $this->assertEquals(CommonPattern::INTEGER->value, RegExpRule::cast($actual[0]->rule)->pattern);
        $this->assertEquals('hogeが、正しい形式ではありません。', $actual[0]->rule->getMessage(new RegExpRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidIncorrectChangeMessage(): void
    {
        $obj = new RegExpRule(CommonPattern::DATE, 'foo.bar.buz');

        $actual = $obj->validate('Hoge', 'hoge', '2024-01-01a');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('2024-01-01a', $actual[0]->value);
        $this->assertInstanceOf(RegExpRule::class, $actual[0]->rule);
        $this->assertEquals(CommonPattern::DATE->value, RegExpRule::cast($actual[0]->rule)->pattern);
        $this->assertEquals('The hoge is not in the correct format.', $actual[0]->rule->getMessage(new RegExpRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidWithDirectMessage(): void
    {
        $obj = new RegExpRule(CommonPattern::INTEGER, message: '{field} is HOGE');

        $actual = $obj->validate('Hoge', 'hoge', '-123a');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('-123a', $actual[0]->value);
        $this->assertInstanceOf(RegExpRule::class, $actual[0]->rule);
        $this->assertEquals(CommonPattern::INTEGER->value, RegExpRule::cast($actual[0]->rule)->pattern);
        $this->assertEquals('hoge is HOGE', $actual[0]->rule->getMessage(new RegExpRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidWithStringPattern(): void
    {
        $obj = new RegExpRule('/^(-{0,1})([0-9]*)$/', message: '{field} is HOGE');

        $actual = $obj->validate('Hoge', 'hoge', '-123a');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('-123a', $actual[0]->value);
        $this->assertInstanceOf(RegExpRule::class, $actual[0]->rule);
        $this->assertEquals(CommonPattern::INTEGER->value, RegExpRule::cast($actual[0]->rule)->pattern);
        $this->assertEquals('hoge is HOGE', $actual[0]->rule->getMessage(new RegExpRuleTestMessagerMock(), ['field' => 'hoge']));
    }
}

class RegExpRuleTestMessagerMock implements MessagerInterface
{
    public function message(string $message_key, array $args = [], string $direct_message = ''): string
    {
        return match (empty ($direct_message)) {
            true => match ($message_key) {
                    'validation.RegExpRule' => MessageFormatter::formatMessage('ja', '{field}が、正しい形式ではありません。', $args),
                    'foo.bar.buz' => MessageFormatter::formatMessage('ja', 'The {field} is not in the correct format.', $args),
                },
            false => MessageFormatter::formatMessage('ja', $direct_message, $args),
        };
    }
}