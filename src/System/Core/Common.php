<?php declare(strict_types=1);

use System\Config\CONFIG;
use System\Helper\DateTimeHelper;
use System\Service\App;
use System\Service\Logging;

if (!function_exists('view')) {
    function view(string $name, array $data = [], string $application = ''): void
    {
        $view_dir = App::get($application)->config()->get(CONFIG::VIEW_DIRECTORY);
        Logging::get('system')->debug('include view: ' . $name, $data);
        include $view_dir . DIRECTORY_SEPARATOR . $name . '.php';
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