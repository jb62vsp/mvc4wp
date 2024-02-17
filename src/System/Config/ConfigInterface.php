<?php declare(strict_types=1);
namespace System\Config;

interface ConfigInterface
{
    public function add(CONFIG $key, string|array $value): void;

    public function get(CONFIG $key): string|array;
}