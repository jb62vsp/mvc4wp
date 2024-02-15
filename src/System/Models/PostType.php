<?php declare(strict_types=1);
namespace System\Models;

use Attribute;
use ReflectionClass;
use System\Exception\ApplicationException;

#[Attribute(Attribute::TARGET_CLASS)]
class PostType
{
    public function __construct(
        public string $post_type = '',
    ) {}

    public static function getPostType(string $class): string
    {
        $ref = new ReflectionClass($class);
        $attrs = $ref->getAttributes(PostType::class);
        if (count($attrs) !== 1) {
            throw new ApplicationException('duplicate PostType.');
        }
        $args = $attrs[0]->getArguments();
        if (array_key_exists('post_type', $args)) {
            return $args['post_type'];
        } elseif (count($args) === 1) {
            return $args[0];
        } else {
            throw new ApplicationException('duplicate parameters.');
        }
    }
}