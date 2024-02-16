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

    public function __construct(
        public string $pattern,
    ) {
    }

    public static function validation(Model $obj, string $property, string $value): void
    {
        $ref = new ReflectionProperty($obj, $property);
        $rules = $ref->getAttributes(Rule::class);
        foreach ($rules as $rule) {
            $args = $rule->getArguments();
            if (count($args) === 1) {
                $matched = preg_match($args[0], $value);
                if (!$matched) {
                    throw new ValidationException(get_class($obj), $property, $value, $args[0]);
                }
            } else {
                throw new ApplicationException();
            }
        }
    }
}