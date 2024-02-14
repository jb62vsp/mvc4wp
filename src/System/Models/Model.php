<?php declare(strict_types=1);
namespace System\Models;

use ReflectionAttribute;
use ReflectionClass;
use ReflectionProperty;
use System\Core\Cast;
use System\Helper\DateTimeHelper;

abstract class Model
{
    use Cast;

    private bool $loaded = false;

    protected function bind(object|array $data): void
    {
        $refc = new ReflectionClass($this);
        $props = $refc->getProperties(ReflectionProperty::IS_PUBLIC);
        foreach ($props as $prop) {
            $this->bindProperty($prop, $data);
        }
    }

    private function bindProperty(ReflectionProperty $prop, object|array|bool|null $data): void
    {
        $prop_name = $prop->getName();
        if (self::_hasKey($data, $prop_name)) {
            $value = self::_getValue($data, $prop_name);
            $typed_value = self::_typedValue($prop->getType()->getName(), $value);
            $prop->setValue($this, $typed_value);
        } else {
            $attrs = $prop->getAttributes(BindableField::class);
            if (count($attrs) === 1) {
                /** @var ReflectionAttribute $attr */
                $attr = $attrs[0];
                $args = $attr->getArguments();
                if (count($args) === 1) {
                    $value = $args['default_value'];
                    $prop->setValue($this, $value);
                }
            }
        }
    }

    private static function _typedValue(string $type, mixed $value): mixed
    {
        return match ($type) {
            'bool' => boolval($value),
            'int' => intval($value, 10),
            'float' => floatval($value),
            'array' => (array) $value,
            'DateTime' => DateTimeHelper::datetimeval($value),
            default => $value,
        };
    }

    private static function _hasKey(object|array|bool $data, $key): bool
    {
        if (is_object($data)) {
            return property_exists($data, $key);
        } elseif (is_array($data)) {
            return array_key_exists($key, $data);
        } elseif (is_bool($data)) {
            return false;
        } else {
            return false;
        }
    }

    private static function _getValue(object|array $data, $key): mixed
    {
        if (is_array($data)) {
            return isset($data[$key]) ? $data[$key] : null;
        } else {
            return isset($data->{$key}) ? $data->{$key} : null;
        }
    }
}