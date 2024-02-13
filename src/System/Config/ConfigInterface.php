<?php declare(strict_types=1);
namespace System\Config;

interface ConfigInterface
{
    public function addConfig(CONFIG $key, string $value): void;

    public function getConfig(CONFIG $key): string;
}