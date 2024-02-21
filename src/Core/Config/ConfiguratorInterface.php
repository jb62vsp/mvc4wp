<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config;

interface ConfiguratorInterface
{
    public function add(string $category, string|array $value): void;

    public function get(string $category, string ...$keys): string|array|null;

    public function set(string $category, string|array $value, string ...$keys): void;
}