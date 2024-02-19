<?php declare(strict_types=1);

use Wp4Mvc\System\Helper\DateTimeHelper;
use Wp4Mvc\System\Service\Locator;

if (!function_exists('view')) {
    function view(string $view_name, array $data = []): void
    {
        Locator::getController()->view($view_name, $data);
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