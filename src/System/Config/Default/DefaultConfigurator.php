<?php declare(strict_types=1);
namespace System\Config\Default;

use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Core\Cast;

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
}