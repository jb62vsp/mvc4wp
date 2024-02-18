<?php declare(strict_types=1);
namespace System\Models;

use ReflectionProperty;
use System\Exception\ValidationException;
use System\Helper\DateTimeHelper;
use System\Models\Validator\Rule;
use System\Models\Validator\ValidationError;
use System\Service\Logging;

trait BindTrait
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

        $props = Bindable::getAttributedProperties(static::class);
        foreach ($props as $prop) {
            try {
                $errors = self::bindProperties($this, $prop, $data, $validation);
                $result = array_merge($result, $errors);
                $this->is_binded = true;
            } catch (ValidationException $ex) {
                Logging::get('system')->debug($ex->getMessage());
                $result[$ex->field] = $ex;
            }
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
        if (self::hasKey($data, $prop_name)) {
            $value = self::getValue($data, $prop_name);
            if (!is_null($value)) {
                $errors = [];
                if ($validation) {
                    $errors = Rule::validate($obj, $prop_name, $value);
                }
                if (count($errors) <= 0) {
                    $typed_value = self::typedValue($prop->getType()->getName(), $value);
                    $prop->setValue($obj, $typed_value);
                } else {
                    $result = array_merge($result, $errors);
                }
            }
        }

        return $result;
    }

    private static function reverseProperty(Model $obj, ReflectionProperty $prop): string
    {
        $prop_name = $prop->getName();
        if (self::hasKey($obj, $prop_name)) {
            $value = self::getValue($obj, $prop_name);
            return self::untypedValue($prop->getType()->getName(), $value);
        }

        return '';
    }

    private static function typedValue(string $type, mixed $value): mixed
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

    private static function untypedValue(string $type, mixed $value): mixed
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