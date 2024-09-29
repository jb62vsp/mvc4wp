<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\CustomPostType;
use Mvc4Wp\Core\Model\PostEntity;
use Mvc4Wp\Core\Model\Validation\CommonPattern;
use Mvc4Wp\Core\Model\Validation\LengthRule;
use Mvc4Wp\Core\Model\Validation\RegExpRule;
use Mvc4Wp\Core\Model\Validation\RequiredRule;

#[CustomPostType(name: 'example', title: ['en_US' => 'Custom Posts', 'ja' => 'カスタム投稿例',], )]
class ExampleEntity extends PostEntity
{
    use Castable;

    #[CustomField(title: ['en_US' => 'Text', 'ja' => 'テキスト例',], type: CustomField::TEXT)]
    #[LengthRule(minimum: 0, max: 10), RequiredRule]
    public string $example_text = '';

    #[CustomField(title: ['en_US' => 'Text Area', 'ja' => 'テキストエリア例',], type: CustomField::TEXTAREA)]
    #[RequiredRule]
    public string $example_textarea = '';

    #[CustomField(title: ['en_US' => 'Integer', 'ja' => '整数例',], type: CustomField::INTEGER)]
    #[RegExpRule(pattern: CommonPattern::INTEGER)]
    public int $example_int = 0;

    #[CustomField(title: ['en_US' => 'Unsigned Integer', '正の整数例',], type: CustomField::UINTEGER)]
    #[RegExpRule(pattern: CommonPattern::UINTEGER)]
    public int $example_uint = 0;

    #[CustomField(title: ['en_US' => 'Float', 'ja' => '浮動小数点数例',], type: CustomField::FLOAT)]
    #[RegExpRule(pattern: CommonPattern::FLOAT)]
    public float $example_float = 0.0;

    #[CustomField(title: ['en_US' => 'Unsigned Float', 'ja' => '正の浮動小数点数例',], type: CustomField::UFLOAT)]
    #[RegExpRule(pattern: CommonPattern::UFLOAT)]
    public float $example_ufloat = 0.0;

    #[CustomField(title: ['en_US' => 'Boolean', 'ja' => '真偽値例',], type: CustomField::BOOL)]
    #[RegExpRule(pattern: CommonPattern::BOOL)]
    public bool $example_bool = false;

    #[CustomField(title: ['en_US' => 'Date', 'ja' => '日付型例',], type: CustomField::DATE)]
    #[RegExpRule(pattern: CommonPattern::DATE)]
    public string $example_date = '';

    #[CustomField(title: ['en_US' => 'Time', 'ja' => '時刻型例',], type: CustomField::TIME)]
    #[RegExpRule(pattern: CommonPattern::TIME)]
    public string $example_time = '';

    #[CustomField(title: ['en_US' => 'DateTime', 'ja' => '日時型例',], type: CustomField::DATETIME)]
    #[RegExpRule(pattern: CommonPattern::DATETIME)]
    public string $example_datetime = '';
}