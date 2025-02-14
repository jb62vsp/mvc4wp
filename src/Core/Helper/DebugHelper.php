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
            if (array_key_exists('file', $s) && array_key_exists('line', $s)) {
                if (!strpos($s['file'], 'Core' . DIRECTORY_SEPARATOR . 'Model')) {
                    $dbg = $dbg . sprintf('%s:%d!', $s['file'], $s['line']);
                }
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
        $bt = debug_backtrace();
        foreach ($bt as $s) {
            if (array_key_exists('file', $s) && array_key_exists('line', $s)) {
                if (!strpos($s['file'], 'Core' . DIRECTORY_SEPARATOR . 'Model')) {
                    $dbg = $dbg . sprintf('%s:%d!', $s['file'], $s['line']);
                }
            }
        }
        $hash = md5($dbg);

        $info['caller'] = explode('!', $dbg)[0];
        $info['start'] = $stopwatch[$hash];
        $info['end'] = $end;
        $info['duration'] = $end - $info['start'];

        debug_add($category, $info);
    }
}

if (!function_exists('debug_view_start')) {
    function debug_view_start(string $view_path, bool $is_html = true): void
    {
        if ($is_html) {
            global $view_count;
            echo "\n<!-- INCLUDE_VIEW_START: {$view_path} -->\n";
            echo "\n<div class='debug debug-view' style='text-indent: {$view_count}rem;'><span class='start'>{$view_path}</span> <span class='nest'>{$view_count}</span></div>\n";
            $view_count += 1;
        } else {
            echo "\n// INCLUDE_VIEW_START: {$view_path}\n";
        }

        global $stopwatch;

        $dbg = '';
        foreach (debug_backtrace() as $s) {
            if (!str_starts_with($s['function'], 'debug_') && array_key_exists('file', $s) && array_key_exists('line', $s)) {
                $dbg = $dbg . sprintf('%s:%d!', $s['file'], $s['line']);
            }
        }
        $hash = md5($dbg);

        $stopwatch[$hash] = microtime(true);
    }
}

if (!function_exists('debug_view_end')) {
    function debug_view_end(string $view_path, array $data, bool $is_html = true): void
    {
        global $stopwatch;

        $end = microtime(true);

        $dbg = '';
        $bt = debug_backtrace();
        foreach ($bt as $s) {
            if (!str_starts_with($s['function'], 'debug_') && array_key_exists('file', $s) && array_key_exists('line', $s)) {
                $dbg = $dbg . sprintf('%s:%d!', $s['file'], $s['line']);
            }
        }
        $hash = md5($dbg);

        $info = ['name' => $view_path, 'data' => $data];
        $info['caller'] = explode('!', $dbg)[0];
        $info['start'] = $stopwatch[$hash];
        $info['end'] = $end;
        $info['duration'] = $end - $info['start'];

        debug_add('view', $info);

        if ($is_html) {
            global $view_count;
            $view_count -= 1;
            echo "\n<div class='debug debug-view' style='text-indent: {$view_count}rem;'><span class='end'>{$view_path}</span> <span class='nest'>{$view_count}</span></div>\n";
            echo "\n<!-- INCLUDE_VIEW_END: {$view_path} -->\n";
        } else {
            echo "\n// INCLUDE_VIEW_END: {$view_path}\n";
        }
    }
}

if (!function_exists('debug_timer_start')) {
    function debug_timer_start(string ...$names): void
    {
        global $stopwatch;

        $start = microtime(true);
        foreach ($names as $name) {
            $hash = md5($name);
            $stopwatch[$hash] = $start;
        }
    }
}

if (!function_exists('debug_timer_end')) {
    function debug_timer_end(string ...$names): void
    {
        global $stopwatch;

        $end = microtime(true);

        foreach ($names as $name) {
            $hash = md5($name);
            $info['name'] = $name;
            $info['start'] = $stopwatch[$hash];
            $info['end'] = $end;
            $info['duration'] = $end - $info['start'];
            debug_add('timer', $info);
        }
    }
}

global $mvc4wp_debug, $stopwatch, $output_debug, $view_count;
$mvc4wp_debug = [];
$stopwatch = [];
$output_debug = true;
$view_count = 0;

Helper::load('View');
WordPressCustomize::enableTraceSQL(function ($q) {
    debug_add('sql', ['sql' => trim(str_replace(["\r\n", "\r", "\n", "\t"], " ", $q))]);
    return $q;
});