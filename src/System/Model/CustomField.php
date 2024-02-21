<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use Attribute;
use Mvc4Wp\System\Library\Cast;

#[Attribute(Attribute::TARGET_PROPERTY)]
class CustomField
{
    use Cast, AttributeTrait;

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
        public string $name,
        public string $title,
        public string $type = self::TEXT,
    ) {
    }

    public static function getName(string $class_name, string $property_name): string
    {
        $attr = static::getPropertyAttribute($class_name, $property_name);
        return $attr->name;
    }

    public static function getTitle(string $class_name, string $property_name): string
    {
        $attr = static::getPropertyAttribute($class_name, $property_name);
        return $attr->title;
    }

    public static function getType(string $class_name, string $property_name): string
    {
        $attr = static::getPropertyAttribute($class_name, $property_name);
        return $attr->type;
    }
}