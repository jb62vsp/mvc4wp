<?php declare(strict_types=1);
namespace App\Models;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\CustomField;
use Mvc4Wp\Core\Model\CustomPostType;
use Mvc4Wp\Core\Model\PostModel;
use Mvc4Wp\Core\Model\Validator\PATTERN;
use Mvc4Wp\Core\Model\Validator\RegExpRule;

#[CustomPostType(name: 'example', title: 'カスタム投稿例')]
class ExampleModel extends PostModel
{
    use Castable;

    #[CustomField(title: 'テキスト例', type: CustomField::TEXT)]
    #[RegExpRule('/^[a-zA-Z0-9]{0,3}$/')]
    public string $example_text = '';

    #[CustomField(title: 'テキストエリア例', type: CustomField::TEXTAREA)]
    public string $example_textarea = '';

    #[CustomField(title: '整数例', type: CustomField::INTEGER)]
    #[RegExpRule(PATTERN::INTEGER)]
    public int $example_int = -1;

    #[CustomField(title: '正の整数例', type: CustomField::UINTEGER)]
    #[RegExpRule(PATTERN::UINTEGER)]
    public int $example_uint = 1;

    #[CustomField(title: '浮動小数点数例', type: CustomField::FLOAT)]
    #[RegExpRule(PATTERN::FLOAT)]
    public float $example_float = -1.0;

    #[CustomField(title: '正の浮動小数点数例', type: CustomField::UFLOAT)]
    #[RegExpRule(PATTERN::UFLOAT)]
    public float $example_ufloat = 1.23;

    #[CustomField(title: '真偽値例', type: CustomField::BOOL)]
    #[RegExpRule(PATTERN::BOOL)]
    public bool $example_bool = false;

    #[CustomField(title: '日付型例', type: CustomField::DATE)]
    #[RegExpRule(PATTERN::DATE)]
    public string $example_date;

    #[CustomField(title: '時刻型例', type: CustomField::TIME)]
    #[RegExpRule(PATTERN::TIME)]
    public string $example_time;

    #[CustomField(title: '日時型例', type: CustomField::DATETIME)]
    #[RegExpRule(PATTERN::DATETIME)]
    public string $example_datetime;
}