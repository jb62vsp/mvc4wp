<?php declare(strict_types=1);
namespace System\Config;

trait ConfigTrait
{
    private array $configs = [];

    public function config(): ConfigInterface
    {
        return $this;
    }

    public function addConfig(CONFIG $key, string $value): void
    {
        $this->configs[$key->value] = $value;
    }

    public function getConfig(CONFIG $key): string
    {
        return $this->configs[$key->value];
    }
}