<?php declare(strict_types=1);
namespace System\Config\Default;

use Exception;
use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Core\Cast;
use System\Exception\ApplicationException;

class DefaultConfigurator implements ConfigInterface
{
    use Cast;

    private array $configs = [];

    public function add(CONFIG $key, string|array $value): void
    {
        $this->configs[$key->value] = $value;
    }

    public function get(CONFIG $key): string|array
    {
        return $this->configs[$key->value];
    }

    public function set(CONFIG $key, string|array $value, string ...$args): void
    {
        try {
            $orig = $this->configs[$key->value];
            $conf = $this->recursive_set($orig, $args, count($args), $value);
            $this->configs[$key->value] = $conf;
        } catch (Exception $ex) {
            throw new ApplicationException('TODO', previous: $ex);
        }
    }

    private function recursive_set(array $arr, array $keys, int $index, string|array $value): array
    {
        $cur = count($keys) - $index;
        if ($index === 1) {
            $arr[$keys[$cur]] = $value;
            return $arr;
        } else {
            $arr[$keys[$cur]] = $this->recursive_set($arr[$keys[$cur]], $keys, $index - 1, $value);
            return $arr;
        }
    }
}