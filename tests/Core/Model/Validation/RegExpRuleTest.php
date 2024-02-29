<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use MessageFormatter;
use Mvc4Wp\Core\Language\MessagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RegExpRule::class)]
class RegExpRuleTest extends TestCase
{
    public const INTEGER = '/^(-{0,1})([0-9]*)$/';

    public const UINTEGER = '/^([0-9]*)$/';

    public const FLOAT = '/^(-{0,1})([0-9\.]*)$/';

    public const UFLOAT = '/^([0-9\.]*)$/';

    public const ALPHABET = '/^([a-zA-Z]*)$/';

    public const ALPHANUM = '/^([a-zA-Z0-9\.]*)$/';

    public const SYMBOL = '/^([ -/:-@[-`{-~]*)$/';

    public const HALFCHAR = '/^([ -~]*)$/';

    public const DATE = '/^(19[0-9]{2}|2[0-9]{3}|[3-9]{4})-([1-9]|0[1-9]|1[0-2])-([1-9]|0[1-9]|[12][0-9]|3[01])$/';

    public const TIME = '/^()|([0-9]|0[0-9]|1[0-9]|2[0-4]):([0-9]|0[0-9]|[1-5][0-9]|60):([0-9]|0[0-9]|[1-5][0-9])$/';

    public const DATETIME = '/^()|(19[0-9]{2}|2[0-9]{3}|[3-9]{4})-([1-9]|0[1-9]|1[0-2])-([1-9]|0[1-9]|[12][0-9]|3[01]) ([0-9]|0[0-9]|1[0-9]|2[0-4]):([0-9]|0[0-9]|[1-5][0-9]):([0-9]|0[0-9]|[1-5][0-9])$/';

    public function test_validate_valid(): void
    {
        $obj = new RegExpRule(self::INTEGER);

        $actual = $obj->validate('Hoge', 'hoge', '-123');
        $this->assertCount(0, $actual);
    }

    public function test_validate_invalidIncorrectInt(): void
    {
        $obj = new RegExpRule(self::INTEGER);

        $actual = $obj->validate('Hoge', 'hoge', '-123a');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('-123a', $actual[0]->value);
        $this->assertInstanceOf(RegExpRule::class, $actual[0]->rule);
        $this->assertEquals(self::INTEGER, RegExpRule::cast($actual[0]->rule)->pattern);
        $this->assertEquals('hogeが、正しい形式ではありません。', $actual[0]->rule->getMessage(new RegExpRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidIncorrectChangeMessage(): void
    {
        $obj = new RegExpRule(self::DATE, 'foo.bar.buz');

        $actual = $obj->validate('Hoge', 'hoge', '2024-01-01a');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('2024-01-01a', $actual[0]->value);
        $this->assertInstanceOf(RegExpRule::class, $actual[0]->rule);
        $this->assertEquals(self::DATE, RegExpRule::cast($actual[0]->rule)->pattern);
        $this->assertEquals('The hoge is not in the correct format.', $actual[0]->rule->getMessage(new RegExpRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidWithDirectMessage(): void
    {
        $obj = new RegExpRule(self::INTEGER, message: '{field} is HOGE');

        $actual = $obj->validate('Hoge', 'hoge', '-123a');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('-123a', $actual[0]->value);
        $this->assertInstanceOf(RegExpRule::class, $actual[0]->rule);
        $this->assertEquals(self::INTEGER, RegExpRule::cast($actual[0]->rule)->pattern);
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