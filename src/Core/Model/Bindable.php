<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Model\Attribute\Field;
use Mvc4Wp\Core\Library\TypeUtils;
use ReflectionMethod;
use ReflectionProperty;

trait Bindable
{
    private bool $is_binded;

    /**
     * @return bool
     */
    public function isBinded(): bool
    {
        return isset($this->is_binded) && $this->is_binded;
    }

    /**
     * @param object|array $values
     * @return void
     */
    public function bind(object|array $values): void
    {
        $props = Field::getAttributedProperties(static::class);
        foreach ($props as $prop) {
            static::bindProperties($this, $prop, $values);
            $this->is_binded = true;
        }
    }

    private static function bindProperties(object $obj, ReflectionProperty $prop, object|array $values): void
    {
        $prop_name = $prop->getName();
        if (TypeUtils::hasKey($values, $prop_name)) {
            $value = TypeUtils::getValue($values, $prop_name);
            if (!is_null($value)) {
                $typed_value = TypeUtils::typedValue($prop->getType()->getName(), $value);
                $refm = new ReflectionMethod($obj, 'setValue');
                $refm->invoke($obj, $prop_name, $typed_value);
            }
        }
    }

    protected static function toString(object $obj, ReflectionProperty $prop): string
    {
        $prop_name = $prop->getName();
        if (TypeUtils::hasKey($obj, $prop_name)) {
            $value = TypeUtils::getValue($obj, $prop_name);
            return TypeUtils::untypedValue($prop->getType()->getName(), $value);
        }

        return '';
    }

    protected static function toArrayOnlyField(object $obj): array
    {
        $result = [];

        $properties = Field::getAttributedProperties(get_class($obj));
        foreach ($properties as $property) {
            $untypedValue = static::toString($obj, $property);
            $property = $property->getName();
            $result[$property] = $untypedValue;
        }

        return $result;
    }
}