<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use ReflectionClass;
use System\Exception\ApplicationException;

#[Attribute(Attribute::TARGET_CLASS)]
class PostType
{
    public function __construct(
        public string $name,
    ) {
    }

    public static function getPostType(string $class): string
    {
        $ref = new ReflectionClass($class);
        $attrs = $ref->getAttributes(PostType::class);
        if (count($attrs) !== 1) {
            throw new ApplicationException('illegal to set PostType.');
        }
        $args = $attrs[0]->getArguments();
        if (array_key_exists('name', $args)) {
            return $args['name'];
        } elseif (count($args) === 1) {
            return $args[0];
        } else {
            throw new ApplicationException('illegal parameters.');
        }
    }
}