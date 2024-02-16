<?php declare(strict_types=1);
namespace System\Models;

use ReflectionProperty;
use System\Core\Cast;
use System\Exception\ValidationException;
use System\Helper\DateTimeHelper;

abstract class Model
{
    use Cast;

    // ---- bind section ----

    public function bind(object|array $data, bool $validation = true): array
    {
        $result = [];

        $props = Bindable::getBindableFields(static::class);
        foreach ($props as $prop) {
            try {
                self::bindProperty($this, $prop, $data, $validation);
            } catch (ValidationException $ex) {
                $result[$ex->field] = $ex;
            }
        }

        return $result;
    }

    private static function bindProperty(Model $obj, ReflectionProperty $prop, object|array $data, bool $validation): void
    {
        $prop_name = $prop->getName();
        if (self::_hasKey($data, $prop_name)) {
            $value = self::_getValue($data, $prop_name);
            if ($validation) {
                Rule::validation($obj, $prop_name, toString($value));
            }
            $typed_value = self::_typedValue($prop->getType()->getName(), $value);
            $prop->setValue($obj, $typed_value);
        }
    }

    private static function reverseProperty(Model $obj, ReflectionProperty $prop): string
    {
        $prop_name = $prop->getName();
        if (self::_hasKey($obj, $prop_name)) {
            $value = self::_getValue($obj, $prop_name);
            return self::_untypedValue($prop->getType()->getName(), $value);
        }

        return '';
    }

    private static function _typedValue(string $type, mixed $value): mixed
    {
        if (is_array($value) && count($value) === 1) {
            $value = $value[0];
        }
        $typed_value = match ($type) {
            'string' => strval($value),
            'int' => intval($value, 10),
            'float' => floatval($value),
            'bool' => boolval($value),
            'DateTime' => DateTimeHelper::datetimeval($value),
            default => $value,
        };

        return $typed_value;
    }

    private static function _untypedValue(string $type, mixed $value): mixed
    {
        if (is_array($value) && count($value) === 1) {
            $value = $value[0];
        }
        $untyped_value = match ($type) {
            'string' => strval($value),
            'int' => strval($value),
            'float' => strval($value),
            'bool' => strval($value),
            'DateTime' => DateTimeHelper::strval($value),
            default => $value,
        };

        return $untyped_value;
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

    #[Bindable]
    public int $ID;

    public function isLoaded(): bool
    {
        return isset($this->ID);
    }

    public static function find(): PostQuery
    {
        return new PostQuery(static::class);
    }

    public function register(): int
    {
        $this->ID = wp_insert_post($this);
        $fields = CustomField::getCustomFields(get_class($this));
        foreach ($fields as $field) {
            $untypedValue = self::reverseProperty($this, $field);
            $property = $field->getName();
            update_post_meta($this->ID, $property, $untypedValue);
        }
        return $this->ID;
    }

    public function update(): void
    {
        wp_update_post($this);
        $fields = CustomField::getCustomFields(get_class($this));
        foreach ($fields as $field) {
            $untypedValue = self::reverseProperty($this, $field);
            $property = $field->getName();
            update_post_meta($this->ID, $property, $untypedValue);
        }
    }

    public function delete(bool $force_delete = false): bool
    {
        if ($force_delete) {
            $result = wp_delete_post($this->ID, force_delete: $force_delete);
        } else {
            $result = wp_trash_post($this->ID);
        }
        if (!$result) {
            return false;
        }
        return true;
    }
}