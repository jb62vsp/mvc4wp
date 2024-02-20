<?php declare(strict_types=1);
namespace Mvc4Wp\System\Config\Default;

use Exception;
use Mvc4Wp\System\Config\AbstractConfigurator;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Exception\ApplicationException;

class DefaultConfigurator extends AbstractConfigurator
{
    use Cast;

    private array $configs = [];

    public function add(string $key, string|array $value): void
    {
        $this->configs[$key] = $value;
    }

    public function get(string $key): string|array
    {
        return $this->configs[$key];
    }

    public function set(string $key, string|array $value, string ...$args): void
    {
        try {
            $orig = $this->configs[$key];
            $conf = $this->recursive_set($orig, $args, count($args), $value);
            $this->configs[$key] = $conf;
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