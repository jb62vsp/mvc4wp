<?php declare(strict_types=1);

use Mvc4Wp\Core\Controller\Controller;
use Mvc4Wp\Core\Controller\CssRenderer;
use Mvc4Wp\Core\Controller\JsRenderer;
use Mvc4Wp\Core\Controller\SassRenderer;
use Mvc4Wp\Core\Controller\ScssRenderer;
use Mvc4Wp\Core\Service\App;

if (!function_exists('view')) {
    function view(string $view_name, array $data = []): void
    {
        App::get()->controller()->view($view_name, $data);
    }
}

if (!function_exists('css')) {
    function css(string $scss_name): void
    {
        $render = new CssRenderer();
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $scss_name);
    }
}

if (!function_exists('sass')) {
    function sass(string $sass_name): void
    {
        $render = new SassRenderer();
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $sass_name);
    }
}

if (!function_exists('scss')) {
    function scss(string $scss_name): void
    {
        $render = new ScssRenderer();
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $scss_name);
    }
}

if (!function_exists('js')) {
    function js(string $js_name): void
    {
        $render = new JsRenderer();
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $js_name);
    }
}

if (!function_exists('eh')) {
    function eh(mixed $value, bool $return = false): string|null
    {
        if ($return) {
            return esc_html($value);
        } else {
            echo esc_html($value);
            return null;
        }
    }
}

if (!function_exists('ea')) {
    function ea(mixed $value, bool $return = false): string|null
    {
        if ($return) {
            return esc_attr($value);
        } else {
            echo esc_attr($value);
            return null;
        }
    }
}

if (!function_exists('eu')) {
    function eu(mixed $value, bool $return = false): string|null
    {
        if ($return) {
            return esc_url($value);
        } else {
            echo esc_url($value);
            return null;
        }
    }
}