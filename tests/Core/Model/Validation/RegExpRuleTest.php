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

    public function test_validate_bool(): void
    {
        $obj = new RegExpRule(CommonPattern::BOOL);
        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::BOOL);
        $actual = $obj->validate('Hoge', 'hoge', strval(true));
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::BOOL);
        $actual = $obj->validate('Hoge', 'hoge', strval(false));
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::BOOL);
        $actual = $obj->validate('Hoge', 'hoge', strval(1));
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::BOOL);
        $actual = $obj->validate('Hoge', 'hoge', strval(0));
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::BOOL);
        $actual = $obj->validate('Hoge', 'hoge', strval(2));
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::BOOL);
        $actual = $obj->validate('Hoge', 'hoge', strval('a'));
        $this->assertCount(1, $actual);
    }

    public function test_validate_integer(): void
    {
        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '0');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '1');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '-1');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '123');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '-123');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '1.23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '-1.23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '1a23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::INTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '-1a23');
        $this->assertCount(1, $actual);
    }

    public function test_validate_uinteger(): void
    {
        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '0');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '1');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '-1');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '123');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '-123');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '1.23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '-1.23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '1a23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UINTEGER);
        $actual = $obj->validate('Hoge', 'hoge', '-1a23');
        $this->assertCount(1, $actual);
    }

    public function test_validate_float(): void
    {
        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '0');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '1');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-1');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '123');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-123');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '1.23');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-1.23');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '12.3');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-12.3');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '1.2.3');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-1.2.3');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '1a23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-1a23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '.12');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::FLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-.12');
        $this->assertCount(1, $actual);
    }

    public function test_validate_ufloat(): void
    {
        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '0');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '1');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-1');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '123');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-123');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '1.23');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-1.23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '12.3');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-12.3');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '1.2.3');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-1.2.3');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '1a23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-1a23');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '.12');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::UFLOAT);
        $actual = $obj->validate('Hoge', 'hoge', '-.12');
        $this->assertCount(1, $actual);
    }

    public function test_validate_alphabet(): void
    {
        $obj = new RegExpRule(CommonPattern::ALPHABET);
        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHABET);
        $actual = $obj->validate('Hoge', 'hoge', 'a');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHABET);
        $actual = $obj->validate('Hoge', 'hoge', 'abcXYZ');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHABET);
        $actual = $obj->validate('Hoge', 'hoge', 'ABCxyz');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHABET);
        $actual = $obj->validate('Hoge', 'hoge', '012abc');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHABET);
        $actual = $obj->validate('Hoge', 'hoge', 'abc_');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHABET);
        $actual = $obj->validate('Hoge', 'hoge', ' abc ');
        $this->assertCount(1, $actual);
    }

    public function test_validate_alphanum(): void
    {
        $obj = new RegExpRule(CommonPattern::ALPHANUM);
        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHANUM);
        $actual = $obj->validate('Hoge', 'hoge', 'a');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHANUM);
        $actual = $obj->validate('Hoge', 'hoge', 'abcXYZ');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHANUM);
        $actual = $obj->validate('Hoge', 'hoge', 'ABCxyz');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHANUM);
        $actual = $obj->validate('Hoge', 'hoge', '012abc');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHANUM);
        $actual = $obj->validate('Hoge', 'hoge', 'abc_');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::ALPHANUM);
        $actual = $obj->validate('Hoge', 'hoge', ' abc ');
        $this->assertCount(1, $actual);
    }

    public function test_validate_date(): void
    {
        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '1-1-1');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '11-01-01');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '111-01-01');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '1111-01-01');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '2000-01-01');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '9999-12-31');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '01-01-01');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '2000-13-01');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '2000-01-32');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::DATE);
        $actual = $obj->validate('Hoge', 'hoge', '10000-01-01');
        $this->assertCount(1, $actual);
    }

    public function test_validate_time(): void
    {
        $obj = new RegExpRule(CommonPattern::TIME);
        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::TIME);
        $actual = $obj->validate('Hoge', 'hoge', '0:0:0');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::TIME);
        $actual = $obj->validate('Hoge', 'hoge', '1:1:1');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::TIME);
        $actual = $obj->validate('Hoge', 'hoge', '23:59:59');
        $this->assertCount(0, $actual);

        $obj = new RegExpRule(CommonPattern::TIME);
        $actual = $obj->validate('Hoge', 'hoge', '24:00:00');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::TIME);
        $actual = $obj->validate('Hoge', 'hoge', '1:60:1');
        $this->assertCount(1, $actual);

        $obj = new RegExpRule(CommonPattern::TIME);
        $actual = $obj->validate('Hoge', 'hoge', '1:1:60');
        $this->assertCount(1, $actual);
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
        $obj = new RegExpRule('/^([0-9]+)$/', message: '{field} is HOGE');

        $actual = $obj->validate('Hoge', 'hoge', '-123a');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('-123a', $actual[0]->value);
        $this->assertInstanceOf(RegExpRule::class, $actual[0]->rule);
        $this->assertEquals('/^([0-9]+)$/', RegExpRule::cast($actual[0]->rule)->pattern);
        $this->assertEquals('hoge is HOGE', $actual[0]->rule->getMessage(new RegExpRuleTestMessagerMock(), ['field' => 'hoge']));
    }
}

class RegExpRuleTestMessagerMock implements MessagerInterface
{
    public function message(string $message_key, array $args = [], string $direct_message = ''): string
    {
        return match (empty($direct_message)) {
            true => match ($message_key) {
                    'validation.RegExpRule' => MessageFormatter::formatMessage('ja', '{field}が、正しい形式ではありません。', $args),
                    'foo.bar.buz' => MessageFormatter::formatMessage('ja', 'The {field} is not in the correct format.', $args),
                },
            false => MessageFormatter::formatMessage('ja', $direct_message, $args),
        };
    }
}