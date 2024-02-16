<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use ReflectionProperty;
use System\Core\Cast;
use System\Exception\ApplicationException;
use System\Exception\ValidationException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Rule
{
    use Cast;

    public const RULES = [
        'BOOL' => '/^1{0,1}$/',
        'INTEGER' => '/^[0-9]*$/',
        'FLOAT' => '/^[0-9\.]*$/',
        'ALPHABET' => '/^[a-zA-Z]*$/',
        'ALPHANUM' => '/^[a-zA-Z0-9\.]*$/',
        'DATE' => '/^(19[0-9]{2}|2[0-9]{3}|[3-9]{4})-([1-9]|0[1-9]|1[0-2])-([1-9]|0[1-9]|[12][0-9]|3[01])$/',
        'TIME' => '/^([0-9]|0[0-9]|1[0-9]|2[0-4]):([0-9]|0[0-9]|[1-5][0-9]|60):([0-9]|0[0-9]|[1-5][0-9])$/',
        'DATETIME' => '/^(19[0-9]{2}|2[0-9]{3}|[3-9]{4})-([1-9]|0[1-9]|1[0-2])-([1-9]|0[1-9]|[12][0-9]|3[01]) ([0-9]|0[0-9]|1[0-9]|2[0-4]):([0-9]|0[0-9]|[1-5][0-9]):([0-9]|0[0-9]|[1-5][0-9])$/',
    ];

    public function __construct(
        public PATTERN $pattern,
    ) {
    }

    public static function validation(Model $obj, string $property, string $value): void
    {
        $ref = new ReflectionProperty($obj, $property);
        $rules = $ref->getAttributes(Rule::class);
        foreach ($rules as $rule) {
            $args = $rule->getArguments();
            if (count($args) === 1) {
                $key = is_array($args[0]) ? $args[0]->value : $args[0];
                $pattern = array_key_exists($key, self::RULES) ? self::RULES[$key] : $key;
                $matched = preg_match($pattern, $value);
                if (!$matched) {
                    throw new ValidationException(get_class($obj), $property, $value, $key);
                }
            } else {
                throw new ApplicationException();
            }
        }
    }
}