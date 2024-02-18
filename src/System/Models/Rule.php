<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use System\Core\Cast;
use System\Exception\ValidationException;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class Rule
{
    use Cast, AttributeTrait;

    public const RULES = [
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

    public function __construct(
        public PATTERN|string $pattern,
    ) {
    }

    public static function validation(Model $obj, string $property_name, string $value): void
    {
        $rules = self::getPropertyAttributes(get_class($obj), $property_name);
        foreach ($rules as $rule) {
            $pattern = self::getPatternString($rule->pattern);
            $matched = preg_match($pattern, $value);
            if (!$matched) {
                $pattern_name = self::getPatternName($rule->pattern);
                throw new ValidationException(get_class($obj), $property_name, $value, $pattern_name);
            }
        }
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