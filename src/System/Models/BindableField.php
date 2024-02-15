<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use DateTime;
use ReflectionClass;
use ReflectionProperty;
use System\Core\Cast;
use System\Exception\ApplicationException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class BindableField
{
    use Cast;

    public function __construct(
        public bool|int|float|array|DateTime|string|null $default_value = null,
    ) {
    }

    public static function getDefaultValue(string $class_name, string $property_name): bool|int|float|array|DateTime|string|null
    {
        $ref = new ReflectionProperty($class_name, $property_name);
        $attrs = $ref->getAttributes(BindableField::class);
        if (count($attrs) <= 0) {
            return null;
        } elseif (count($attrs) !== 1) {
            throw new ApplicationException('illegal to set BindableField.');
        }
        $args = $attrs[0]->getArguments();
        if (count($args) <= 0) {
            return null;
        } elseif (array_key_exists('default_value', $args)) {
            return $args['default_value'];
        } elseif (count($args) === 1) {
            return $args[0];
        } else {
            throw new ApplicationException('illegal parameters.');
        }
    }

    public static function getBindableFields(string $class_name): array
    {
        $refc = new ReflectionClass($class_name);
        $props = $refc->getProperties(ReflectionProperty::IS_PUBLIC);
        $result = array_filter($props, function (ReflectionProperty $prop) {
            $attrs = $prop->getAttributes(BindableField::class);
            return count($attrs) === 1;
        });
        return $result;
    }

    public static function getBindableFieldNames(string $class_name): array
    {
        $props = self::getBindableFields($class_name);
        $result = array_map(function (ReflectionProperty $prop) {
            return $prop->getName();
        }, $props);
        return $result;
    }
}