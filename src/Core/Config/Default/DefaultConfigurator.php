<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config\Default;

use Mvc4Wp\Core\Config\AbstractConfigurator;
use Mvc4Wp\Core\Library\Castable;

class DefaultConfigurator extends AbstractConfigurator
{
    use Castable;

    private array $configs = [];

    public function add(string $category, string|array $value): void
    {
        if (!array_key_exists($category, $this->configs)) {
            $this->configs[$category] = $value;
        }
    }

    public function get(string $category, string ...$keys): string|array|null
    {
        if (array_key_exists($category, $this->configs)) {
            if (empty($keys)) {
                return $this->configs[$category];
            } else {
                return $this->recursiveGet($this->configs[$category], $keys, count($keys));
            }
        } else {
            return null;
        }
    }

    public function set(string $category, string|array $value, string ...$keys): void
    {
        if (array_key_exists($category, $this->configs)) {
            if (empty($keys)) {
                $this->configs[$category] = $value;
            } else {
                $orig = $this->configs[$category];
                $conf = $this->recursiveSet($orig, $keys, count($keys), $value);
                $this->configs[$category] = $conf;
            }
        }
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
            if (array_key_exists($key, $arr)) {
                $arr[$key] = $value;
            }
            return $arr;
        } else {
            $arr[$key] = $this->recursiveSet($arr[$keys[$cur]], $keys, $index - 1, $value);
            return $arr;
        }
    }
}