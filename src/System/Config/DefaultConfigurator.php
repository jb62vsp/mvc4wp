<?php declare(strict_types=1);
namespace System\Config;

use System\Core\Cast;

class DefaultConfigurator implements ConfigInterface
{
    use Cast;

    private array $configs = [];

    public function add(CONFIG $key, string $value): void
    {
        $this->configs[$key->value] = $value;
    }

    public function get(CONFIG $key): string
    {
        return $this->configs[$key->value];
    }
}