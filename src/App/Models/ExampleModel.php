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
    #[CustomField(slug: 'example_string', title: '文字列例')]
    #[Rule('/^[a-zA-Z0-9]{0,3}$/')]
    public string $example_string = '';

    #[Bindable]
    #[CustomField(slug: 'example_int', title: '整数例')]
    #[Rule(PATTERN::INTEGER->value)]
    public int $example_int = -1;

    #[Bindable]
    #[CustomField(slug: 'example_float', title: '浮動小数点数例')]
    #[Rule(PATTERN::FLOAT->value)]
    public float $example_float = -1.0;

    #[Bindable]
    #[CustomField(slug: 'example_bool', title: '真偽値例')]
    #[Rule(PATTERN::BOOL->value)]
    public bool $example_bool = false;

    #[Bindable]
    #[CustomField(slug: 'example_datetime', title: '日時型例')]
    #[Rule(PATTERN::DATE->value)]
    public ?DateTime $example_datetime = null;

    public function format(string $field): string
    {
        if ($field === 'example_datetime') {
            return eh(DateTimeHelper::strval($this->{$field}, DateTimeHelper::DATE_FORMAT));
        } else {
            return eh($this->{$field});
        }
    }
}