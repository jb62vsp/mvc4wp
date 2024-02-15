<?php declare(strict_types=1);

use System\Application\Application;
use System\Config\CONFIG;
use System\Helper\DateTimeHelper;

if (!function_exists('view')) {
    function view(string $name, array $data = [], array $options = []): void
    {
        global $wpmvc_app;
        $view_dir = Application::cast($wpmvc_app)->getConfig(CONFIG::VIEW_DIRECTORY);
        include $view_dir . DIRECTORY_SEPARATOR . $name . '.php';
    }
}

if (!function_exists('v')) {
    function v(mixed $value): string
    {
        $result = '';

        if ($value instanceof DateTime) {
            $result = DateTimeHelper::strval($value);
        } else {
            $result = strval($value);
        }

        $result = esc_html($result);

        return $result;
    }
}