<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use ReflectionClass;
use System\Core\Cast;
use System\Exception\ApplicationException;

#[Attribute(Attribute::TARGET_CLASS)]
class PostType
{
    use Cast, AttributeTrait;

    public function __construct(
        public string $name,
    ) {
    }

    public static function getName(string $class_name): string
    {
        return self::getSingleClassAttributeValue($class_name, 'name');
    }
}