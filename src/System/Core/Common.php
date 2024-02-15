<?php declare(strict_types=1);

use System\Application\Application;
use System\Config\CONFIG;

if (!function_exists('view')) {
    function view(string $name, array $data = [], array $options = []): void
    {
        global $wpmvc_app;
        $view_dir = Application::cast($wpmvc_app)->getConfig(CONFIG::VIEW_DIRECTORY);
        include $view_dir . DIRECTORY_SEPARATOR . $name . '.php';
    }
}