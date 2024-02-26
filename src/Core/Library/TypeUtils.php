<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

class TypeUtils
{
    public static function hasKey(object|array $values, $key): bool
    {
        if (is_array($values)) {
            return array_key_exists($key, $values);
        } else {
            return property_exists($values, $key);
        }
    }

    public static function getValue(object|array $values, $key): string|int|float|bool|null
    {
        $result = null;

        if (is_array($values)) {
            $result = $values[$key] ?? null;
        } else {
            $result = $values->{$key} ?? null;
        }

        if (is_array($result) && count($result) === 1) {
            $result = $result[0];
        }

        return $result;
    }

    public static function typedValue(string $type, string|int|float|bool|null $value): string|int|float|bool|null
    {
        if (is_null($value)) {
            return null;
        }

        $typed_value = match (strtolower($type)) {
            'null' => null,
            'string' => strval($value),
            'int' => intval($value, 10),
            'float' => floatval($value),
            'bool' => boolval($value),
            // 'DateTime' => DateTimeUtils::datetimeval($value), // TODO:
            default => $value,
        };

        return $typed_value;
    }

    public static function untypedValue(string $type, string|int|float|bool|null $value): string
    {
        if (is_null($value)) {
            return '';
        }

        $untyped_value = match (strtolower($type)) {
            'null' => '',
            'string' => strval($value),
            'int' => strval($value),
            'float' => strval($value),
            'bool' => strval($value),
            // 'DateTime' => DateTimeUtils::strval($value, 'Y-m-d H:i:s'), // TODO:
            default => $value,
        };

        return $untyped_value;
    }
}