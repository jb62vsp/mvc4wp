<?php declare(strict_types=1);
namespace System\Core;

use InvalidArgumentException;

trait Cast
{
    public static function is($obj): bool
    {
        return $obj instanceof self;
    }

    public static function used(object $obj): bool
    {
        $classes = array_merge([$obj], class_parents($obj));
        $exists = false;
        foreach ($classes as $class) {
            $traits = class_uses($class);
            if (in_array(self::class, $traits)) {
                $exists = true;
                break;
            }
        }

        return $exists;
    }

    public static function cast($obj): self
    {
        if (!self::is($obj)) {
            throw new InvalidArgumentException();
        }

        return $obj;
    }

    public static function cast_null($obj): ?self
    {
        if (is_null($obj)) {
            return null;
        } elseif (!self::is($obj)) {
            throw new InvalidArgumentException();
        }

        return $obj;
    }
}
