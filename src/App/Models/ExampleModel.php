<?php declare(strict_types=1);
namespace App\Models;

use DateTime;
use System\Core\Cast;
use System\Helper\DateTimeHelper;
use System\Models\Bindable;
use System\Models\CustomField;
use System\Models\CustomPostType;
use System\Models\PATTERN;
use System\Models\PostModel;
use System\Models\PostType;
use System\Models\Rule;

#[PostType(name: 'example')]
#[CustomPostType(slug: 'example', title: 'カスタム投稿例')]
class ExampleModel extends PostModel
{
    use Cast;

    #[Bindable]
    #[CustomField(slug: 'example_text', title: 'テキスト例', type: CustomField::TEXT)]
    #[Rule('/^[a-zA-Z0-9]{0,3}$/')]
    public string $example_text = '';

    #[Bindable]
    #[CustomField(slug: 'example_textarea', title: 'テキストエリア例', type: CustomField::TEXTAREA)]
    public string $example_textarea = '';

    #[Bindable]
    #[CustomField(slug: 'example_int', title: '整数例', type: CustomField::INTEGER)]
    #[Rule(PATTERN::INTEGER->value)]
    public int $example_int = -1;

    #[Bindable]
    #[CustomField(slug: 'example_uint', title: '正の整数例', type: CustomField::UINTEGER)]
    #[Rule(PATTERN::UINTEGER->value)]
    public int $example_uint = 1;

    #[Bindable]
    #[CustomField(slug: 'example_float', title: '浮動小数点数例', type: CustomField::FLOAT)]
    #[Rule(PATTERN::FLOAT->value)]
    public float $example_float = -1.0;

    #[Bindable]
    #[CustomField(slug: 'example_ufloat', title: '正の浮動小数点数例', type: CustomField::UFLOAT)]
    #[Rule(PATTERN::UFLOAT->value)]
    public float $example_ufloat = 1.23;

    #[Bindable]
    #[CustomField(slug: 'example_bool', title: '真偽値例', type: CustomField::BOOL)]
    #[Rule(PATTERN::BOOL->value)]
    public bool $example_bool = false;

    #[Bindable]
    #[CustomField(slug: 'example_date', title: '日付型例', type: CustomField::DATE)]
    #[Rule(PATTERN::DATE->value)]
    public DateTime $example_date;

    #[Bindable]
    #[CustomField(slug: 'example_time', title: '時刻型例', type: CustomField::TIME)]
    #[Rule(PATTERN::TIME->value)]
    public DateTime $example_time;

    #[Bindable]
    #[CustomField(slug: 'example_datetime', title: '日時型例', type: CustomField::DATETIME)]
    #[Rule(PATTERN::DATETIME->value)]
    public DateTime $example_datetime;

    public function format(string $field): string
    {
        return match ($field) {
            'example_date' => eh(DateTimeHelper::strval($this->{$field}, DateTimeHelper::DATE_FORMAT)),
            'example_time' => eh(DateTimeHelper::strval($this->{$field}, DateTimeHelper::TIME_FORMAT)),
            'example_datetime' => eh(DateTimeHelper::strval($this->{$field}, DateTimeHelper::DATETIME_FORMAT)),
            default => eh($this->{$field}),
        };
    }
}