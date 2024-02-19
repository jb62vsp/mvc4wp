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
#[CustomPostType(name: 'example', title: 'カスタム投稿例')]
class ExampleModel extends PostModel
{
    use Cast;

    #[Bindable]
    #[CustomField(name: 'example_text', title: 'テキスト例', type: CustomField::TEXT)]
    #[Rule('/^[a-zA-Z0-9]{0,3}$/')]
    public string $example_text = '';

    #[Bindable]
    #[CustomField(name: 'example_textarea', title: 'テキストエリア例', type: CustomField::TEXTAREA)]
    public string $example_textarea = '';

    #[Bindable]
    #[CustomField(name: 'example_int', title: '整数例', type: CustomField::INTEGER)]
    #[Rule(PATTERN::INTEGER)]
    public int $example_int = -1;

    #[Bindable]
    #[CustomField(name: 'example_uint', title: '正の整数例', type: CustomField::UINTEGER)]
    #[Rule(PATTERN::UINTEGER)]
    public int $example_uint = 1;

    #[Bindable]
    #[CustomField(name: 'example_float', title: '浮動小数点数例', type: CustomField::FLOAT)]
    #[Rule(PATTERN::FLOAT)]
    public float $example_float = -1.0;

    #[Bindable]
    #[CustomField(name: 'example_ufloat', title: '正の浮動小数点数例', type: CustomField::UFLOAT)]
    #[Rule(PATTERN::UFLOAT)]
    public float $example_ufloat = 1.23;

    #[Bindable]
    #[CustomField(name: 'example_bool', title: '真偽値例', type: CustomField::BOOL)]
    #[Rule(PATTERN::BOOL)]
    public bool $example_bool = false;

    #[Bindable]
    #[CustomField(name: 'example_date', title: '日付型例', type: CustomField::DATE)]
    #[Rule(PATTERN::DATE)]
    public DateTime $example_date;

    #[Bindable]
    #[CustomField(name: 'example_time', title: '時刻型例', type: CustomField::TIME)]
    #[Rule(PATTERN::TIME)]
    public DateTime $example_time;

    #[Bindable]
    #[CustomField(name: 'example_datetime', title: '日時型例', type: CustomField::DATETIME)]
    #[Rule(PATTERN::DATETIME)]
    public ?DateTime $example_datetime;

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