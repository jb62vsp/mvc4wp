<?php declare(strict_types=1);

use Mvc4Wp\System\Helper\DateTimeHelper;
use Mvc4Wp\System\Service\App;

if (!function_exists('view')) {
    function view(string $view_name, array $data = [], string $application_name = ''): void
    {
        App::get($application_name)->controller()->view($view_name, $data);
    }
}

if (!function_exists('toString')) {
    function toString(mixed $value): string
    {
        $result = '';

        if ($value instanceof DateTime) {
            $result = DateTimeHelper::strval($value);
        } else {
            $result = strval($value);
        }

        return $result;
    }
}

if (!function_exists('eh')) {
    function eh(mixed $value): string
    {
        return esc_html(toString($value));
    }
}

if (!function_exists('ea')) {
    function ea(mixed $value): string
    {
        return esc_attr(toString($value));
    }
}

if (!function_exists('eu')) {
    function eu(mixed $value): string
    {
        return esc_attr(toString($value));
    }
}