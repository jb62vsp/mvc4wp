<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use ReflectionClass;
use ReflectionProperty;
use System\Core\Cast;
use System\Exception\ApplicationException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CustomField
{
    use Cast;

    public const TEXT = 'TEXT';

    public const TEXTAREA = 'TEXTAREA';

    public const INTEGER = 'INTEGER';
    
    public const UINTEGER = 'UINTEGER';

    public const FLOAT = 'FLOAT';

    public const UFLOAT = 'UFLOAT';

    public const BOOL = 'BOOL';

    public const DATE = 'DATE';

    public const TIME = 'TIME';

    public const DATETIME = 'DATETIME';

    public function __construct(
        public string $slug,
        public string $title,
        public string $type,
    ) {
    }

    public static function getCustomFields(string $class_name): array
    {
        $refc = new ReflectionClass($class_name);
        $props = $refc->getProperties(ReflectionProperty::IS_PUBLIC);
        $result = array_filter($props, function (ReflectionProperty $prop) {
            $attrs = $prop->getAttributes(CustomField::class);
            return count($attrs) === 1;
        });
        return $result;
    }

    public static function getCustomFieldNames(string $class_name): array
    {
        $props = self::getCustomFields($class_name);
        $result = array_map(function (ReflectionProperty $prop) {
            return $prop->getName();
        }, $props);
        return $result;
    }

    public static function getSlug(string $class_name, string $property_name): string
    {
        return self::get($class_name, $property_name, 'slug');
    }

    public static function getTitle(string $class_name, string $property_name): string
    {
        return self::get($class_name, $property_name, 'title');
    }

    public static function getType(string $class_name, string $property_name): string
    {
        return self::get($class_name, $property_name, 'type');
    }

    private static function get(string $class_name, string $property_name, string $argument_name): string
    {
        $ref = new ReflectionProperty($class_name, $property_name);
        $attrs = $ref->getAttributes(CustomField::class);
        if (count($attrs) !== 1) {
            throw new ApplicationException('illegal to set CustomField.');
        }
        $args = $attrs[0]->getArguments();
        if (array_key_exists($argument_name, $args)) {
            return $args[$argument_name];
        } else {
            throw new ApplicationException('illegal parameters.');
        }
    }
}