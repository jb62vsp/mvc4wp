<?php declare(strict_types=1);

if (!function_exists('is_debug')) {
    function is_debug(): bool {
        return false;
    }
}

if (!function_exists('debug_view')) {
    function debug_view(string $view_name = 'body.php', array $data = []): void
    {
    }
}

if (!function_exists('debug_do')) {
    function debug_do(callable $func): void {
    }
}

if (!function_exists('debug_add')) {
    function debug_add(string $category, mixed $info): void
    {
    }
}

if (!function_exists('debug_add_var')) {
    function debug_add_var(string $name, mixed $var): void
    {
    }
}

if (!function_exists('debug_add_start')) {
    function debug_add_start(): void
    {
    }
}

if (!function_exists('debug_add_end')) {
    function debug_add_end(string $category, mixed $info): void
    {
    }
}

if (!function_exists('debug_view_start')) {
    function debug_view_start(string $view_path): void
    {
    }
}

if (!function_exists('debug_view_end')) {
    function debug_view_end(string $view_path, array $data): void
    {
    }
}