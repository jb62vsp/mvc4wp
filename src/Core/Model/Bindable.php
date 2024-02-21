<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use DateTime;
use ReflectionMethod;
use ReflectionProperty;
use Mvc4Wp\Core\Helper\DateTimeHelper;
use Mvc4Wp\Core\Model\Validator\Rule;
use Mvc4Wp\Core\Model\Validator\ValidationError;

trait Bindable
{
    private bool $is_binded = false;

    public function idBinded(): bool
    {
        return $this->is_binded;
    }

    /**
     * @return array<ValidationError>
     */
    public function bind(object|array $data, bool $validation = true): array
    {
        $result = [];

        $props = Field::getAttributedProperties(static::class);
        foreach ($props as $prop) {
            $errors = static::bindProperties($this, $prop, $data, $validation);
            $result = array_merge($result, $errors);
            $this->is_binded = true;
        }

        return $result;
    }

    /**
     * @return array<ValidationError>
     */
    private static function bindProperties(Model $obj, ReflectionProperty $prop, object|array $data, bool $validation): array
    {
        $result = [];

        $prop_name = $prop->getName();
        if (static::hasKey($data, $prop_name)) {
            $value = static::getValue($data, $prop_name);
            if (!is_null($value)) {
                $errors = [];
                if ($validation) {
                    $errors = Rule::validate($obj, $prop_name, $value);
                }
                if (count($errors) <= 0) {
                    $typed_value = static::typedValue($prop->getType()->getName(), $value);
                    $refm = new ReflectionMethod($obj, 'setValue');
                    $refm->invoke($obj, $prop_name, $typed_value);
                } else {
                    $result = array_merge($result, $errors);
                }
            }
        }

        return $result;
    }

    protected static function reverseProperty(Model $obj, ReflectionProperty $prop): string
    {
        $prop_name = $prop->getName();
        if (static::hasKey($obj, $prop_name)) {
            $value = static::getValue($obj, $prop_name);
            return static::untypedValue($prop->getType()->getName(), $value);
        }

        return '';
    }

    protected static function toArrayOnlyField(Model $obj): array
    {
        $result = [];

        $properties = Field::getAttributedProperties(get_class($obj));
        foreach ($properties as $property) {
            $untypedValue = static::reverseProperty($obj, $property);
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
            'DateTime' => DateTimeHelper::datetimeval($value),
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
            'DateTime' => DateTimeHelper::strval($value),
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