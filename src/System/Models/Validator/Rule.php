<?php declare(strict_types=1);
namespace System\Models\Validator;

use Attribute;
use System\Core\Cast;
use System\Models\AttributeTrait;
use System\Models\Model;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
abstract class Rule
{
    use Cast, AttributeTrait;

    /**
     * @return array<ValidationError>
     */
    public static function validate(Model $obj, string $property_name, mixed $value): array
    {
        $result = [];

        $class_name = get_class($obj);
        $rules = static::getPropertyAllAttributes($class_name, $property_name);
        foreach ($rules as $rule) {
            if ($rule->inherited(static::class)) {
                $errors = $rule->_validate($class_name, $property_name, $value);
                if (count($errors) > 0) {
                    $result = array_merge($result, $errors);
                }
            }
        }

        return $result;
    }

    abstract public function getMessage(array $args = []): string;

    /**
     * @return array<ValidationError>
     */
    abstract protected function _validate(string $class_name, string $property_name, mixed $value): array;
}