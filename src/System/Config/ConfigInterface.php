<?php declare(strict_types=1);
namespace Mvc4Wp\System\Config;

interface ConfigInterface
{
    public function add(string $key, string|array $value): void;

    public function get(string $key): string|array;

    public function set(string $key, string $value, string ...$keys): void;
}