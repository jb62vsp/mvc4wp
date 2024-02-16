<?php declare(strict_types=1);
namespace App\Models;

use DateTime;
use System\Core\Cast;
use System\Models\Bindable;
use System\Models\CustomField;
use System\Models\CustomPostType;
use System\Models\PostModel;
use System\Models\PostType;

#[PostType(name: 'example')]
#[CustomPostType(slug: 'example', title: 'カスタム投稿例')]
class ExampleModel extends PostModel
{
    use Cast;

    #[Bindable(default_value: '')]
    #[CustomField(slug: 'example_string', title: '文字列例')]
    public string $example_string;

    #[Bindable(default_value: 0)]
    #[CustomField(slug: 'example_int', title: '整数例')]
    public int $example_int;

    #[Bindable(default_value: 0.0)]
    #[CustomField(slug: 'example_float', title: '浮動小数点数例')]
    public float $example_float;

    #[Bindable(default_value: false)]
    #[CustomField(slug: 'example_bool', title: '真偽値例')]
    public bool $example_bool;

    #[Bindable(default_value: null)]
    #[CustomField(slug: 'example_datetime', title: '日時型例')]
    public DateTime $example_datetime;
}