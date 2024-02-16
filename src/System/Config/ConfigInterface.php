<?php declare(strict_types=1);
namespace System\Config;

interface ConfigInterface
{
    public function add(CONFIG $key, string $value): void;

    public function get(CONFIG $key): string;
}