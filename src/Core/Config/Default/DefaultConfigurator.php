<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config\Default;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Library\Castable;

class DefaultConfigurator implements ConfiguratorInterface
{
    use Castable;

    public const KEY_SEPARATOR = '.';

    private array $configs = [];

    public function add(string $key, string|array $value): void
    {
        $this->configs[$key] = $value;
    }

    public function get(string $key): string|array|null
    {
        $keys = explode(self::KEY_SEPARATOR, $key);
        if (empty($keys)) {
            return null;
        }

        return $this->recursiveGet($this->configs, $keys, count($keys));
    }

    public function set(string $key, string|array $value): void
    {
        $keys = explode(self::KEY_SEPARATOR, $key);
        if (empty($keys)) {
            return;
        }

        $this->configs = $this->recursiveSet($this->configs, $keys, count($keys), $value);
    }

    private function recursiveGet(array $arr, array $keys, int $index): string|array|null
    {
        $cur = count($keys) - $index;
        $key = $keys[$cur];
        if ($index === 1) {
            if (array_key_exists($key, $arr)) {
                return $arr[$key];
            } else {
                return null;
            }
        } else {
            return $this->recursiveGet($arr[$key], $keys, $index - 1);
        }
    }

    private function recursiveSet(array $arr, array $keys, int $index, string|array $value): string|array
    {
        $cur = count($keys) - $index;
        $key = $keys[$cur];
        if ($index === 1) {
            $arr[$key] = $value;
            return $arr;
        } else {
            $arr[$key] = $this->recursiveSet($arr[$keys[$cur]], $keys, $index - 1, $value);
            return $arr;
        }
    }
}