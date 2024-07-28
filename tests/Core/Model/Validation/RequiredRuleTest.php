<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use MessageFormatter;
use Mvc4Wp\Core\Language\MessagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(RequiredRule::class)]
class RequiredRuleTest extends TestCase
{
    public function test_validate_valid(): void
    {
        $obj = new RequiredRule();

        $actual = $obj->validate('Hoge', 'hoge', 'HOGE');
        $this->assertCount(0, $actual);
    }

    public function test_validate_invalid(): void
    {
        $obj = new RequiredRule();

        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('', $actual[0]->value);
        $this->assertInstanceOf(RequiredRule::class, $actual[0]->rule);
        $this->assertEquals('hogeは、必須です。', $actual[0]->rule->getMessage(new RequiredRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_invalidChangeMessage(): void
    {
        $obj = new RequiredRule('foo.bar.buz');

        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('', $actual[0]->value);
        $this->assertInstanceOf(RequiredRule::class, $actual[0]->rule);
        $this->assertEquals('The hoge is required.', $actual[0]->rule->getMessage(new RequiredRuleTestMessagerMock(), ['field' => 'hoge']));
    }

    public function test_validate_intValid(): void
    {
        $obj = new RequiredRule();

        $actual = $obj->validate('Hoge', 'hoge', 0);
        $this->assertCount(0, $actual);
    }

    public function test_validate_invalidWithDirectMessage(): void
    {
        $obj = new RequiredRule(message: '{field} is HOGE');

        $actual = $obj->validate('Hoge', 'hoge', '');
        $this->assertCount(1, $actual);
        $this->assertEquals('Hoge', $actual[0]->class_name);
        $this->assertEquals('hoge', $actual[0]->property_name);
        $this->assertEquals('', $actual[0]->value);
        $this->assertInstanceOf(RequiredRule::class, $actual[0]->rule);
        $this->assertEquals('hoge is HOGE', $actual[0]->rule->getMessage(new RequiredRuleTestMessagerMock(), ['field' => 'hoge']));
    }

}

class RequiredRuleTestMessagerMock implements MessagerInterface
{
    public function message(string $message_key, array $args = [], string $direct_message = ''): string
    {
        return match (empty ($direct_message)) {
            true => match ($message_key) {
                    'validation.RequiredRule' => MessageFormatter::formatMessage('ja', '{field}は、必須です。', $args),
                    'foo.bar.buz' => MessageFormatter::formatMessage('ja', 'The {field} is required.', $args),
                },
            false => MessageFormatter::formatMessage('ja', $direct_message, $args),
        };
    }
}