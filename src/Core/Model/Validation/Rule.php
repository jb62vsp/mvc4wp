<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

use Attribute;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\AttributeTrait;
use Mvc4Wp\Core\Model\Entity;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
abstract class Rule
{
    use Castable, AttributeTrait;

    /**
     * @return array<ValidationError>
     */
    public static function validate(Entity $obj, string $property_name, mixed $value): array
    {
        $result = [];

        $class_name = get_class($obj);
        $rules = static::getPropertyAllAttributes($class_name, $property_name);
        foreach ($rules as $rule) {
            if ($rule->extend(static::class)) {
                $errors = $rule->_validate($class_name, $property_name, $value);
                if (count($errors) > 0) {
                    $result[$property_name] = $errors;
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