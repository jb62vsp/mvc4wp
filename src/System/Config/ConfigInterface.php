<?php declare(strict_types=1);
namespace Wp4Mvc\System\Config;

interface ConfigInterface
{
    public function add(CONFIG $key, string|array $value): void;

    public function get(CONFIG $key): string|array;

    public function set(CONFIG $key, string $value, string ...$keys): void;
}