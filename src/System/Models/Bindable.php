<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use DateTime;
use ReflectionClass;
use ReflectionProperty;
use System\Core\Cast;
use System\Exception\ApplicationException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Bindable
{
    use Cast;

    public function __construct() {
    }

    public static function getBindableFields(string $class_name): array
    {
        $refc = new ReflectionClass($class_name);
        $props = $refc->getProperties(ReflectionProperty::IS_PUBLIC);
        $result = array_filter($props, function (ReflectionProperty $prop) {
            $attrs = $prop->getAttributes(Bindable::class);
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