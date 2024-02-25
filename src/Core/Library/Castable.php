<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

use InvalidArgumentException;

trait Castable
{
    /**
     * all situation.
     * @param object|string<class-string> $child_or_parent
     * @return bool was same or child or parent.
     */
    public static function is(object|string $child_or_parent): bool
    {
        $result = false;

        $result = static::equals($child_or_parent);
        if ($result) {
            return true;
        }

        $result = static::extend($child_or_parent);
        if ($result) {
            return true;
        }

        $result = static::extended($child_or_parent);

        return $result;
    }

    /**
     * left operator equals right operator.
     * @param object|string<class-string> $object_or_class
     * @return bool was same.
     */
    public static function equals(object|string $object_or_class): bool
    {
        $result = false;

        $class = '';
        if (is_string($object_or_class)) {
            $class = $object_or_class;
        } else {
            $class = get_class($object_or_class);
        }
        $result = $class === static::class;

        return $result;
    }

    /**
     * left operator extends right operator.
     * @param object|string<class-string> $parent
     * @return bool was parent.
     */
    public static function extend(object|string $parent): bool
    {
        $result = false;

        if (is_string($parent)) {
            $result = is_subclass_of(static::class, $parent);
        } else {
            $result = is_subclass_of(static::class, get_class($parent));
        }

        return $result;
    }

    /**
     * right operator extends left operator.
     * @param object|string<class-string> $child
     * @return bool was child.
     */
    public static function extended(object|string $child): bool
    {
        return is_subclass_of($child, static::class);
    }

    /**
     * DO NOT upcast(only equals OR extended).
     * @param object $object
     * @return static casted object.
     */
    public static function cast(object $object): static
    {
        if (static::equals($object)) {
            return $object;
        } elseif (static::extended($object)) {
            return $object;
        }

        throw new InvalidArgumentException();
    }

    /**
     * DO NOT upcast(only equals OR extended).
     * @param object $object
     * @return static|null casted object or null.
     */
    public static function cast_null(object|null $object): static|null
    {
        if (is_null($object)) {
            return null;
        }

        return static::cast($object);
    }
}
