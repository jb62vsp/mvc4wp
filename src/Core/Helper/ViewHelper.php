<?php declare(strict_types=1);

use Mvc4Wp\Core\Service\DateTimeService;
use Mvc4Wp\Core\Service\App;

if (!function_exists('view')) {
    function view(string $view_name, array $data = []): void
    {
        App::get()->controller()->view($view_name, $data);
    }
}

if (!function_exists('eh')) {
    function eh(mixed $value): string
    {
        return esc_html($value);
    }
}

if (!function_exists('ea')) {
    function ea(mixed $value): string
    {
        return esc_attr($value);
    }
}

if (!function_exists('eu')) {
    function eu(mixed $value): string
    {
        return esc_attr($value);
    }
}