<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\TypeUtils;
use Mvc4Wp\Core\Model\Validation\Rule;
use Mvc4Wp\Core\Model\Validation\ValidationError;

trait Validatable
{
    /**
     * @return array<string, array<ValidationError>>
     */
    public function validate(object|array $values): array
    {
        $result = [];

        $props = Rule::getAttributedProperties(get_class($this));
        foreach ($props as $prop) {
            $property_name = $prop->getName();
            if (TypeUtils::hasKey($values, $property_name)) {
                $value = TypeUtils::getValue($values, $property_name);
                $errors = $this->validateProperty($property_name, $value);
                if (!empty($errors)) {
                    $result[$property_name] = $errors;
                }
            }
        }

        return $result;
    }

    public function validateProperty(string $property_name, string|int|float|bool $value): array
    {
        $result = [];

        $class_name = get_class($this);
        $rules = Rule::getPropertyAllAttributes($class_name, $property_name);
        foreach ($rules as $rule) {
            if ($rule->extend(Rule::class)) {
                $errors = $rule->validate($class_name, $property_name, $value);
                $result = array_merge($result, $errors);
            }
        }

        return $result;
    }
}