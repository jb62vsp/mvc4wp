<?php declare(strict_types=1);
namespace App\Model;

use DateTime;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Helper\DateTimeHelper;
use Mvc4Wp\System\Model\Bindable;
use Mvc4Wp\System\Model\CustomField;
use Mvc4Wp\System\Model\CustomPostType;
use Mvc4Wp\System\Model\PostModel;
use Mvc4Wp\System\Model\PostType;
use Mvc4Wp\System\Model\Validator\LengthRule;
use Mvc4Wp\System\Model\Validator\NumericRule;
use Mvc4Wp\System\Model\Validator\PATTERN;
use Mvc4Wp\System\Model\Validator\RegExpRule;

/**
 * @template TModel of ExampleModel
 * @extends PostModel<TModel>
 */
#[PostType(name: 'example')]
#[CustomPostType(name: 'example', title: 'カスタム投稿例')]
class ExampleModel extends PostModel
{
    use Cast;

    #[Bindable]
    #[CustomField(name: 'example_text', title: 'テキスト例', type: CustomField::TEXT)]
    #[LengthRule(0, 3, '%s文字から%s文字まで')]
    public string $example_text = '';

    #[Bindable]
    #[CustomField(name: 'example_textarea', title: 'テキストエリア例', type: CustomField::TEXTAREA)]
    public string $example_textarea = '';

    #[Bindable]
    #[CustomField(name: 'example_int', title: '整数例', type: CustomField::INTEGER)]
    #[RegExpRule(PATTERN::INTEGER, '整数のみ')]
    public int $example_int = -1;

    #[Bindable]
    #[CustomField(name: 'example_uint', title: '正の整数例', type: CustomField::UINTEGER)]
    #[NumericRule('正の整数のみ')]
    public int $example_uint = 1;

    #[Bindable]
    #[CustomField(name: 'example_float', title: '浮動小数点数例', type: CustomField::FLOAT)]
    #[RegExpRule(PATTERN::FLOAT, '浮動小数点数のみ')]
    public float $example_float = -1.0;

    #[Bindable]
    #[CustomField(name: 'example_ufloat', title: '正の浮動小数点数例', type: CustomField::UFLOAT)]
    #[RegExpRule(PATTERN::UFLOAT, '正の浮動小数点数のみ')]
    public float $example_ufloat = 1.23;

    #[Bindable]
    #[CustomField(name: 'example_bool', title: '真偽値例', type: CustomField::BOOL)]
    #[RegExpRule(PATTERN::BOOL, '真偽値のみ')]
    public bool $example_bool = false;

    #[Bindable]
    #[CustomField(name: 'example_date', title: '日付型例', type: CustomField::DATE)]
    #[RegExpRule(PATTERN::DATE, '日付のみ')]
    public string $example_date;

    #[Bindable]
    #[CustomField(name: 'example_time', title: '時刻型例', type: CustomField::TIME)]
    #[RegExpRule(PATTERN::TIME, '時刻のみ')]
    public string $example_time;

    #[Bindable]
    #[CustomField(name: 'example_datetime', title: '日時型例', type: CustomField::DATETIME)]
    #[RegExpRule(PATTERN::DATETIME, '日時のみ')]
    public string $example_datetime;

    public function format(string $field): string
    {
        return eh($this->{$field});
    }
}