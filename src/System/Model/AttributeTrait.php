<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use ArgumentCountError;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use Mvc4Wp\System\Exception\ApplicationException;

trait AttributeTrait
{
    public static function getClassAttribute(string $class_name): static
    {
        $refc = new ReflectionClass($class_name);
        $attrs = $refc->getAttributes(static::class);
        if (count($attrs) === 0) {
            throw new ApplicationException('not set ' . $class_name);
        } elseif (count($attrs) !== 1) {
            throw new ApplicationException('duplicate to set ' . $class_name);
        }
        $result = $attrs[0]->newInstance();

        return $result;
    }

    public static function getPropertyAttribute(string $class_name, string $property_name): static
    {
        $refc = new ReflectionProperty($class_name, $property_name);
        $attrs = $refc->getAttributes(static::class);
        if (count($attrs) === 0) {
            throw new ApplicationException('not set ' . $class_name);
        } elseif (count($attrs) !== 1) {
            throw new ApplicationException('duplicate to set ' . $class_name);
        }
        $result = $attrs[0]->newInstance();

        return $result;
    }

    /**
     * @return array<static>
     */
    public static function getPropertyAttributes(string $class_name, string $property_name): array
    {
        $refp = new ReflectionProperty($class_name, $property_name);
        $attrs = $refp->getAttributes(static::class);
        $result = array_map(fn($attr) => $attr->newInstance(), $attrs);

        return $result;
    }

    /**
     * @return array<self>
     */
    public static function getPropertyAllAttributes(string $class_name, string $property_name): array
    {
        $refp = new ReflectionProperty($class_name, $property_name);
        $attrs = $refp->getAttributes();
        $result = array_map(fn($attr) => $attr->newInstance(), $attrs);

        return $result;
    }

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
        $refc = new ReflectionClass($class_name);
        $attrs = $refc->getAttributes(static::class);
        if (count($attrs) === 0) {
            throw new ApplicationException('not set ' . $class_name . ', ' . $attribute_key);
        } elseif (count($attrs) !== 1) {
            throw new ApplicationException('duplicate to set ' . $class_name . ', ' . $attribute_key);
        }
        try {
            return self::getValueByAttribute($attrs[0], $attribute_key);
        } catch (ApplicationException $ex) {
            throw new ApplicationException($ex->getMessage() . ', ' . $class_name, previous: $ex);
        }
    }

    protected static function getSinglePropertyAttributeValue(string $class_name, string $property_name, string $attribute_key): mixed
    {
        $refp = new ReflectionProperty($class_name, $property_name);
        $attrs = $refp->getAttributes(static::class);
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
            $inst = $attr->newInstance();
            if (property_exists($inst, $attribute_key)) {
                return $inst->{$attribute_key};
            } else {
                throw new ApplicationException('not set ' . $attr->getName() . '::' . $attribute_key);
            }
        } catch (ArgumentCountError $ex) {
            throw new ApplicationException('not set ' . $attr->getName() . '::' . $attribute_key);
        }
    }
}