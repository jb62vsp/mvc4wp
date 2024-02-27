<?php declare(strict_types=1);

use Mvc4Wp\Core\Library\Debug\DebugViewRenderer;
use Mvc4Wp\Core\Library\WordPressCustomize;
use Mvc4Wp\Core\Service\App;

if (!function_exists('debug_view')) {
    function debug_view(string $view_name = 'body.php', array $data = []): void
    {
        $renderer = new DebugViewRenderer();
        $renderer->render(App::get()->config(), $renderer, $view_name);
    }
}

if (!function_exists('add_debug')) {
    function add_debug(string $category, mixed $info): void
    {
        global $mvc4wp_debug;

        if (!array_key_exists($category, $mvc4wp_debug)) {
            $mvc4wp_debug[$category] = [];
        }
        $info['microtime'] = microtime(true);

        $mvc4wp_debug[$category][] = $info;
    }
}

if (!function_exists('view_start')) {
    function view_start(string $view_path)
    {
        echo "\n<!-- INCLUDE_VIEW_START: {$view_path} -->\n";
        echo "\n<div class='debug view'>START: {$view_path}</div>\n";
    }
}

if (!function_exists('view_end')) {
    function view_end(string $view_path)
    {
        echo "\n<div class='debug view'>END: {$view_path}</div>\n";
        echo "\n<!-- INCLUDE_VIEW_END: {$view_path} -->\n";
    }
}

global $mvc4wp_debug;
$mvc4wp_debug = [];

WordPressCustomize::enableTraceSQL(function ($q) {
    add_debug('sql', ['sql' => trim(str_replace(["\r\n", "\r", "\n", "\t"], " ", $q))]);
    return $q;
});

debug_view('head.php');