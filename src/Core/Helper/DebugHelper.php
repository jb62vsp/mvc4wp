<?php declare(strict_types=1);

use Mvc4Wp\Core\Library\Debug\DebugViewRenderer;
use Mvc4Wp\Core\Library\WordPressCustomize;
use Mvc4Wp\Core\Service\App;
use Mvc4Wp\Core\Service\Helper;

if (!function_exists('is_debug')) {
    function is_debug(): bool
    {
        return true;
    }
}

if (!function_exists('debug_view')) {
    function debug_view(string $view_name = '', array $data = []): void
    {
        $renderer = new DebugViewRenderer();
        if (empty($view_name)) {
            $renderer->render(App::get()->config(), $renderer, 'head.php');
            $renderer->render(App::get()->config(), $renderer, 'body.php');
        } else {
            $renderer->render(App::get()->config(), $renderer, $view_name);
        }
    }
}

if (!function_exists('debug_do')) {
    function debug_do(callable $func): void
    {
        $func();
    }
}

if (!function_exists('debug_add')) {
    function debug_add(string $category, mixed $info): void
    {
        global $mvc4wp_debug;

        if (!array_key_exists($category, $mvc4wp_debug)) {
            $mvc4wp_debug[$category] = [];
        }
        // $info['microtime'] = microtime(true);

        $mvc4wp_debug[$category][] = $info;
    }
}

if (!function_exists('debug_add_var')) {
    function debug_add_var(string $name, mixed $var): void
    {
        debug_add('var', [$name => $var]);
    }
}

if (!function_exists('debug_add_start')) {
    function debug_add_start(): void
    {
        global $stopwatch;

        $dbg = '';
        foreach (debug_backtrace() as $s) {
            if (!str_starts_with($s['function'], 'debug_')) {
                $dbg = $dbg . sprintf('%s:%d!', $s['file'], $s['line']);
            }
        }
        $hash = md5($dbg);

        $stopwatch[$hash] = microtime(true);
    }
}

if (!function_exists('debug_add_end')) {
    function debug_add_end(string $category, mixed $info): void
    {
        global $stopwatch;

        $end = microtime(true);

        $dbg = '';
        foreach (debug_backtrace() as $s) {
            if (!str_starts_with($s['function'], 'debug_')) {
                $dbg = $dbg . sprintf('%s:%d!', $s['file'], $s['line']);
            }
        }
        $hash = md5($dbg);

        $info['start'] = $stopwatch[$hash];
        $info['end'] = $end;
        $info['duration'] = $end - $info['start'];

        debug_add($category, $info);
    }
}

if (!function_exists('debug_view_start')) {
    function debug_view_start(string $view_path): void
    {
        echo "\n<!-- INCLUDE_VIEW_START: {$view_path} -->\n";
        echo "\n<div class='debug view'>START: {$view_path}</div>\n";
        debug_add_start();
    }
}

if (!function_exists('debug_view_end')) {
    function debug_view_end(string $view_path, array $data): void
    {
        debug_add_end('view', ['name' => $view_path, 'data' => $data]);
        echo "\n<div class='debug view'>END: {$view_path}</div>\n";
        echo "\n<!-- INCLUDE_VIEW_END: {$view_path} -->\n";
    }
}

global $mvc4wp_debug, $stopwatch;
$mvc4wp_debug = [];
$stopwatch = [];

Helper::load('View');
WordPressCustomize::enableTraceSQL(function ($q) {
    debug_add('sql', ['sql' => trim(str_replace(["\r\n", "\r", "\n", "\t"], " ", $q))]);
    return $q;
});