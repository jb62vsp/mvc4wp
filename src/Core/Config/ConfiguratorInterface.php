<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Config;

interface ConfiguratorInterface
{
    public function add(string $key, string|array $value): void;

    public function get(string $key): string|array|null;

    public function getAll(): array;

    public function set(string $key, string|array $value): void;
}