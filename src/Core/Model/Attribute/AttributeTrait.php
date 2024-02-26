<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Attribute;

use ReflectionClass;
use ReflectionProperty;
use Mvc4Wp\Core\Exception\ApplicationException;

trait AttributeTrait
{
    public static function getClassAttribute(string $class_name): static
    {
        $refc = new ReflectionClass($class_name);
        $attrs = $refc->getAttributes();
        foreach ($attrs as $attr) {
            $instance = $attr->newInstance();
            if ($instance->equals(static::class) || $instance->extend(static::class)) {
                return $instance;
            }
        }

        throw new ApplicationException(sprintf('Attribute "%s" is not set to "%s"', static::class, $class_name));
    }

    public static function getPropertyAttribute(string $class_name, string $property_name): static
    {
        $refc = new ReflectionProperty($class_name, $property_name);
        $attrs = $refc->getAttributes();
        foreach ($attrs as $attr) {
            $instance = $attr->newInstance();
            if ($instance->equals(static::class) || $instance->extend(static::class)) {
                return $instance;
            }
        }

        throw new ApplicationException(sprintf('Attribute "%s" is not set to "%s::%s"', static::class, $class_name, $property_name));
    }

    /**
     * @return array<static>
     */
    public static function getPropertyAttributes(string $class_name, string $property_name): array
    {
        $result = [];

        $refp = new ReflectionProperty($class_name, $property_name);
        $attrs = $refp->getAttributes();
        foreach ($attrs as $attr) {
            $instance = $attr->newInstance();
            if ($instance->equals(static::class) || $instance->extend(static::class)) {
                $result[] = $instance;
            }
        }

        return $result;
    }

    /**
     * @return array<static>
     */
    public static function getPropertyAllAttributes(string $class_name, string $property_name): array
    {
        $refp = new ReflectionProperty($class_name, $property_name);
        $attrs = $refp->getAttributes();
        $result = array_map(fn($attr) => $attr->newInstance(), $attrs);

        return $result;
    }

    /**
     * @return array<ReflectionProperty>
     */
    public static function getAttributedProperties(string $class_name): array
    {
        $result = [];

        $refc = new ReflectionClass($class_name);
        $props = $refc->getProperties();
        foreach ($props as $prop) {
            $attrs = $prop->getAttributes();
            foreach ($attrs as $attr) {
                $instance = $attr->newInstance();
                if ($instance->equals(static::class) || $instance->extend(static::class)) {
                    $result[] = $prop;
                    break;
                }
            }
        }

        return $result;
    }

    public static function getAttributedPropertyNames(string $class_name): array
    {
        $props = static::getAttributedProperties($class_name);
        $result = array_map(function (ReflectionProperty $prop) {
            return $prop->getName();
        }, $props);
        return $result;
    }
}