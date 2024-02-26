<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

final class RetrieveArray
{
    public static function get(array $array, array $keys): string|array|null
    {
        if (empty($array)) {
            return null;
        }
        if (empty($keys)) {
            return null;
        }

        return self::recursiveGet($array, $keys, count($keys));
    }

    public static function set(array $array, array $keys, string|array $value): string|array|null
    {
        if (empty($array)) {
            return null;
        }
        if (empty($keys)) {
            return null;
        }

        return self::recursiveSet($array, $keys, count($keys), $value);
    }


    private static function recursiveGet(array $array, array $keys, int $index): string|array|null
    {
        $cur = count($keys) - $index;
        $key = $keys[$cur];
        if ($index === 1) {
            if (array_key_exists($key, $array)) {
                return $array[$key];
            } else {
                return null;
            }
        } elseif (array_key_exists($key, $array)) {
            return self::recursiveGet($array[$key], $keys, $index - 1);
        } else {
            return null;
        }
    }

    private static function recursiveSet(array $array, array $keys, int $index, string|array $value): string|array
    {
        $cur = count($keys) - $index;
        $key = $keys[$cur];
        if ($index === 1) {
            $array[$key] = $value;
            return $array;
        } elseif (array_key_exists($key, $array)) {
            $array[$key] = self::recursiveSet($array[$key], $keys, $index - 1, $value);
            return $array;
        } else {
            $array[$key] = [];
            $array[$key] = self::recursiveSet($array[$key], $keys, $index - 1, $value);
            return $array;
        }
    }
}