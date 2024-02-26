<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\CustomPostType;
use Mvc4Wp\Core\Model\PostEntity;
use Mvc4Wp\Core\Model\Validation\CommonPattern;
use Mvc4Wp\Core\Model\Validation\LengthRule;
use Mvc4Wp\Core\Model\Validation\RegExpRule;

#[CustomPostType(name: 'example', title: 'カスタム投稿例')]
class ExampleEntity extends PostEntity
{
    use Castable;

    #[CustomField(title: 'テキスト例', type: CustomField::TEXT)]
    #[LengthRule(minimum: 1, max: 10)]
    public string $example_text = '';

    #[CustomField(title: 'テキストエリア例', type: CustomField::TEXTAREA)]
    public string $example_textarea = '';

    #[CustomField(title: '整数例', type: CustomField::INTEGER)]
    #[RegExpRule(pattern: CommonPattern::INTEGER->value)]
    public int $example_int = -1;

    #[CustomField(title: '正の整数例', type: CustomField::UINTEGER)]
    #[RegExpRule(pattern: CommonPattern::UINTEGER->value)]
    public int $example_uint = 1;

    #[CustomField(title: '浮動小数点数例', type: CustomField::FLOAT)]
    #[RegExpRule(pattern: CommonPattern::FLOAT->value)]
    public float $example_float = -1.0;

    #[CustomField(title: '正の浮動小数点数例', type: CustomField::UFLOAT)]
    #[RegExpRule(pattern: CommonPattern::UFLOAT->value)]
    public float $example_ufloat = 1.23;

    #[CustomField(title: '真偽値例', type: CustomField::BOOL)]
    #[RegExpRule(pattern: CommonPattern::BOOL->value)]
    public bool $example_bool = false;

    #[CustomField(title: '日付型例', type: CustomField::DATE)]
    #[RegExpRule(pattern: CommonPattern::DATE->value)]
    public string $example_date;

    #[CustomField(title: '時刻型例', type: CustomField::TIME)]
    #[RegExpRule(pattern: CommonPattern::TIME->value)]
    public string $example_time;

    #[CustomField(title: '日時型例', type: CustomField::DATETIME)]
    #[RegExpRule(pattern: CommonPattern::DATETIME->value)]
    public string $example_datetime;
}