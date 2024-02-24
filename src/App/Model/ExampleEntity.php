<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\CustomPostType;
use Mvc4Wp\Core\Model\PostEntity;
use Mvc4Wp\Core\Model\Validator\LengthRule;
use Mvc4Wp\Core\Model\Validator\NumericRule;
use Mvc4Wp\Core\Model\Validator\PATTERN;
use Mvc4Wp\Core\Model\Validator\RegExpRule;

#[CustomPostType(name: 'example', title: 'カスタム投稿例')]
class ExampleEntity extends PostEntity
{
    use Castable;

    #[CustomField(title: 'テキスト例', type: CustomField::TEXT)]
    #[LengthRule(0, 3, '%s文字から%s文字まで')]
    public string $example_text = '';

    #[CustomField(title: 'テキストエリア例', type: CustomField::TEXTAREA)]
    public string $example_textarea = '';

    #[CustomField(title: '整数例', type: CustomField::INTEGER)]
    #[RegExpRule(PATTERN::INTEGER, '整数のみ')]
    public int $example_int = -1;

    #[CustomField(title: '正の整数例', type: CustomField::UINTEGER)]
    #[NumericRule('正の整数のみ')]
    public int $example_uint = 1;

    #[CustomField(title: '浮動小数点数例', type: CustomField::FLOAT)]
    #[RegExpRule(PATTERN::FLOAT, '浮動小数点数のみ')]
    public float $example_float = -1.0;

    #[CustomField(title: '正の浮動小数点数例', type: CustomField::UFLOAT)]
    #[RegExpRule(PATTERN::UFLOAT, '正の浮動小数点数のみ')]
    public float $example_ufloat = 1.23;

    #[CustomField(title: '真偽値例', type: CustomField::BOOL)]
    #[RegExpRule(PATTERN::BOOL, '真偽値のみ')]
    public bool $example_bool = false;

    #[CustomField(title: '日付型例', type: CustomField::DATE)]
    #[RegExpRule(PATTERN::DATE, '日付のみ')]
    public string $example_date;

    #[CustomField(title: '時刻型例', type: CustomField::TIME)]
    #[RegExpRule(PATTERN::TIME, '時刻のみ')]
    public string $example_time;

    #[CustomField(title: '日時型例', type: CustomField::DATETIME)]
    #[RegExpRule(PATTERN::DATETIME, '日時のみ')]
    public string $example_datetime;
}