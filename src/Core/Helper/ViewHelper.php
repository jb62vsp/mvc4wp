<?php declare(strict_types=1);

use Mvc4Wp\Core\Controller\Controller;
use Mvc4Wp\Core\Controller\ScssRenderer;
use Mvc4Wp\Core\Service\App;

if (!function_exists('view')) {
    function view(string $view_name, array $data = []): void
    {
        App::get()->controller()->view($view_name, $data);
    }
}

if (!function_exists('scss')) {
    function scss(string $scss_name): void
    {
        $render = new ScssRenderer();
        // $render->use_cache = true; // TODO: cache
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $scss_name);
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