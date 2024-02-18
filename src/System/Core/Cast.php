<?php declare(strict_types=1);
namespace System\Core;

use InvalidArgumentException;

trait Cast
{
    public static function is(mixed $obj): bool
    {
        $result = $obj instanceof static;
        return $result;
    }

    public function inherited(string $parent): bool
    {
        $result = is_subclass_of($this, $parent);
        return $result;
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
