<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model\Validator;

use Attribute;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Model\AttributeTrait;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class RegExpRule extends Rule
{
    use Cast, AttributeTrait;

    public const RULES = [
        'NONE' => '/^.*$/',
        'BOOL' => '/^(1{0,1})$/',
        'INTEGER' => '/^(-{0,1})([0-9]*)$/',
        'UINTEGER' => '/^([0-9]*)$/',
        'FLOAT' => '/^(-{0,1})([0-9\.]*)$/',
        'UFLOAT' => '/^([0-9\.]*)$/',
        'ALPHABET' => '/^([a-zA-Z]*)$/',
        'ALPHANUM' => '/^([a-zA-Z0-9\.]*)$/',
        'SYMBOL' => '/^([ -/:-@[-`{-~]*)$/',
        'HALFCHAR' => '/^([ -~]*)$/',
        'DATE' => '/^()|(19[0-9]{2}|2[0-9]{3}|[3-9]{4})-([1-9]|0[1-9]|1[0-2])-([1-9]|0[1-9]|[12][0-9]|3[01])$/',
        'TIME' => '/^()|([0-9]|0[0-9]|1[0-9]|2[0-4]):([0-9]|0[0-9]|[1-5][0-9]|60):([0-9]|0[0-9]|[1-5][0-9])$/',
        'DATETIME' => '/^()|(19[0-9]{2}|2[0-9]{3}|[3-9]{4})-([1-9]|0[1-9]|1[0-2])-([1-9]|0[1-9]|[12][0-9]|3[01]) ([0-9]|0[0-9]|1[0-9]|2[0-4]):([0-9]|0[0-9]|[1-5][0-9]):([0-9]|0[0-9]|[1-5][0-9])$/',
    ];

    public string $pattern_name;

    public function __construct(
        public PATTERN|string $pattern = PATTERN::NONE,
        public string $message = '',
    ) {
        $this->pattern_name = self::getPatternName($pattern);
    }

    public function _validate(string $class_name, string $property_name, mixed $value): array
    {
        $result = [];

        $pattern = self::getPatternString($this->pattern);
        $matched = preg_match($pattern, $value);
        if (!$matched) {
            array_push($result, new ValidationError($class_name, $property_name, $value, $this));
        }

        return $result;
    }

    public function getMessage(array $args = []): string
    {
        return sprintf($this->message, $this->pattern);
    }

    private static function getPatternString(PATTERN|string $pattern_name): string
    {
        $result = $pattern_name;
        if (!is_string($result) && get_class($result) === PATTERN::class) {
            $result = self::RULES[$result->value];
        }
        return $result;
    }

    private static function getPatternName(PATTERN|string $pattern_name): string
    {
        $result = $pattern_name;
        if (!is_string($result) && get_class($result) === PATTERN::class) {
            $result = $result->value;
        }
        return $result;
    }
}