<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config\Default;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\RetrieveArray;

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

        return RetrieveArray::get($this->configs, $keys);
    }

    public function set(string $key, string|array $value): void
    {
        $keys = explode(self::KEY_SEPARATOR, $key);
        if (empty($keys)) {
            return;
        }

        $this->configs = RetrieveArray::set($this->configs, $keys, $value);
    }
}