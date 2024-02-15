<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use ReflectionClass;
use System\Core\Cast;
use System\Exception\ApplicationException;

#[Attribute(Attribute::TARGET_CLASS)]
class CustomPostType
{
    use Cast;
    
    public function __construct(
        public string $slug,
        public string $title,
    ) {
    }

    private static function get(string $class_name, string $property_name): string
    {
        $ref = new ReflectionClass($class_name);
        $attrs = $ref->getAttributes(CustomPostType::class);
        if (count($attrs) !== 1) {
            throw new ApplicationException('illegal to set CustomPostType.');
        }
        $args = $attrs[0]->getArguments();
        if (array_key_exists($property_name, $args)) {
            return $args[$property_name];
        } else {
            throw new ApplicationException('illegal parameters.');
        }
    }

    public static function getSlug(string $class_name): string
    {
        return self::get($class_name, 'slug');
    }

    public static function getTitle(string $class_name): string
    {
        return self::get($class_name, 'title');
    }
}