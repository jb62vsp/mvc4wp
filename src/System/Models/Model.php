<?php declare(strict_types=1);
namespace System\Models;

use ReflectionClass;
use ReflectionProperty;
use System\Core\Cast;
use System\Helper\DateTimeHelper;

abstract class Model
{
    use Cast;

    // ---- bind section ----

    public static function getBindableFieldNames(): array
    {
        $props = self::getBindableFields();
        $result = array_map(function (ReflectionProperty $prop) {
            return $prop->getName();
        }, $props);
        return $result;
    }

    public function bind(object|array $data): void
    {
        $props = self::getBindableFields();
        foreach ($props as $prop) {
            self::bindProperty($this, $prop, $data);
        }
    }

    private static function getBindableFields(): array
    {
        $refc = new ReflectionClass(static::class);
        $props = $refc->getProperties(ReflectionProperty::IS_PUBLIC);
        $result = array_filter($props, function (ReflectionProperty $prop) {
            $attrs = $prop->getAttributes(BindableField::class);
            return count($attrs) === 1;
        });
        return $result;
    }

    private static function bindProperty(Model $obj, ReflectionProperty $prop, object|array $data): void
    {
        $prop_name = $prop->getName();
        if (self::_hasKey($data, $prop_name)) {
            $value = self::_getValue($data, $prop_name);
            $typed_value = self::_typedValue($prop->getType()->getName(), $value);
            $prop->setValue($obj, $typed_value);
        } else {
            $default_value = BindableField::getDefaultValue(get_class($obj), $prop_name);
            if (!is_null($default_value)) {
                $prop->setValue($obj, $default_value);
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

    private static function _hasKey(object|array $data, $key): bool
    {
        if (is_object($data)) {
            return property_exists($data, $key);
        } elseif (is_array($data)) {
            return array_key_exists($key, $data);
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

    // ---- repository section ----

    #[BindableField]
    public int $ID;

    public function isLoaded(): bool
    {
        return isset($this->ID);
    }

    public static function find(): PostQueryBuilder
    {
        return new PostQueryBuilder(static::class);
    }

    public function register(): int
    {
        $this->ID = wp_insert_post($this);

        return $this->ID;
    }

    public function update(): void
    {
        wp_update_post($this);
    }

    public function delete(bool $force_delete = false): bool
    {
        $result = wp_delete_post($this->ID, force_delete: $force_delete);
        if (!$result) {
            return false;
        }
        return true;
    }
}