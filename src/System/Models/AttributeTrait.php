<?php declare(strict_types=1);
namespace System\Models;

use ArgumentCountError;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use System\Exception\ApplicationException;

trait AttributeTrait
{
    public static function getAttributedProperties(string $class_name): array
    {
        $refc = new ReflectionClass($class_name);
        $props = $refc->getProperties();
        $result = array_filter($props, function (ReflectionProperty $prop) {
            $attrs = $prop->getAttributes(static::class);
            return count($attrs) === 1;
        });
        return $result;
    }

    public static function getAttributedPropertyNames(string $class_name): array
    {
        $props = self::getAttributedProperties($class_name);
        $result = array_map(function (ReflectionProperty $prop) {
            return $prop->getName();
        }, $props);
        return $result;
    }

    protected static function getSingleClassAttributeValue(string $class_name, string $attribute_key): mixed
    {
        $ref = new ReflectionClass($class_name);
        $attrs = $ref->getAttributes(static::class);
        if (count($attrs) !== 1) {
            throw new ApplicationException('illegal to set ' . $class_name . ', ' . $attribute_key);
        }
        try {
            return self::getValueByAttribute($attrs[0], $attribute_key);
        } catch (ApplicationException $ex) {
            throw new ApplicationException($ex->getMessage() . ', ' . $class_name, previous: $ex);
        }
    }

    protected static function getSinglePropertyAttributeValue(string $class_name, string $property_name, string $attribute_key): mixed
    {
        $ref = new ReflectionProperty($class_name, $property_name);
        $attrs = $ref->getAttributes(static::class);
        if (count($attrs) === 0) {
            throw new ApplicationException('not set ' . $class_name . '::' . $property_name);
        } elseif (count($attrs) !== 1) {
            throw new ApplicationException('duplicate to set ' . $class_name . '::' . $property_name);
        }
        try {
            return self::getValueByAttribute($attrs[0], $attribute_key);
        } catch (ApplicationException $ex) {
            throw new ApplicationException($ex->getMessage() . ', ' . $class_name . '::' . $property_name, previous: $ex);
        }
    }

    protected static function getValueByAttribute(ReflectionAttribute $attr, string $attribute_key): mixed
    {
        try {
            $obj = $attr->newInstance();
            if (property_exists($obj, $attribute_key)) {
                return $obj->{$attribute_key};
            } else {
                throw new ApplicationException('not set ' . $attr->getName() . '::' . $attribute_key);
            }
        } catch (ArgumentCountError $ex) {
            throw new ApplicationException('not set ' . $attr->getName() . '::' . $attribute_key);
        }
    }
}