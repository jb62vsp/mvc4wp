<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use DateTime;
use Mvc4Wp\Core\Model\Attribute\Field;
use Mvc4Wp\Core\Service\DateTimeService;
use ReflectionMethod;
use ReflectionProperty;

trait Bindable
{
    private bool $is_binded = false;

    public function isBinded(): bool
    {
        return $this->is_binded;
    }

    public function bind(object|array $data): void
    {
        $props = Field::getAttributedProperties(static::class);
        foreach ($props as $prop) {
            static::bindProperties($this, $prop, $data);
            $this->is_binded = true;
        }
    }

    private static function bindProperties(object $obj, ReflectionProperty $prop, object|array $data): void
    {
        $prop_name = $prop->getName();
        if (static::hasKey($data, $prop_name)) {
            $value = static::getValue($data, $prop_name);
            if (!is_null($value)) {
                $typed_value = static::typedValue($prop->getType()->getName(), $value);
                $refm = new ReflectionMethod($obj, 'setValue');
                $refm->invoke($obj, $prop_name, $typed_value);
            }
        }
    }

    protected static function toString(object $obj, ReflectionProperty $prop): string
    {
        $prop_name = $prop->getName();
        if (static::hasKey($obj, $prop_name)) {
            $value = static::getValue($obj, $prop_name);
            return static::untypedValue($prop->getType()->getName(), $value);
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

    private static function typedValue(string $type, string|int|float|bool|DateTime $value): string|int|float|bool|DateTime
    {
        if (is_array($value) && count($value) === 1) {
            $value = $value[0];
        }
        $typed_value = match ($type) {
            'string' => strval($value),
            'int' => intval($value, 10),
            'float' => floatval($value),
            'bool' => boolval($value),
            'DateTime' => DateTimeService::datetimeval($value),
            default => $value,
        };

        return $typed_value;
    }

    private static function untypedValue(string $type, string|int|float|bool|DateTime|null $value): string
    {
        if (is_null($value)) {
            return '';
        }
        if (is_array($value) && count($value) === 1) {
            $value = $value[0];
        }
        $untyped_value = match ($type) {
            'string' => strval($value),
            'int' => strval($value),
            'float' => strval($value),
            'bool' => strval($value),
            'DateTime' => DateTimeService::strval($value, 'Y-m-d H:i:s'), // TODO:
            default => $value,
        };

        return $untyped_value;
    }

    private static function hasKey(object|array $data, $key): bool
    {
        if (is_object($data)) {
            return property_exists($data, $key);
        } elseif (is_array($data)) {
            return array_key_exists($key, $data);
        } else {
            return false;
        }
    }

    private static function getValue(object|array $data, $key): mixed
    {
        $result = null;

        if (is_array($data)) {
            $result = isset($data[$key]) ? $data[$key] : null;
        } else {
            $result = isset($data->{$key}) ? $data->{$key} : null;
        }

        if (is_array($result) && count($result) === 1) {
            $result = $result[0];
        }

        return $result;
    }
}