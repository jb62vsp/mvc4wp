<?php

declare(strict_types=1);

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
    function css(string $scss_name, array $attrs = []): void
    {
        $render = new CssRenderer();
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $scss_name, $attrs);
    }
}

if (!function_exists('cssd')) {
    function cssd(string $scss_name, array $attrs = []): void
    {
        $render = new CssRenderer(false);
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $scss_name, $attrs);
    }
}

if (!function_exists('sass')) {
    function sass(string $sass_name, array $attrs = []): void
    {
        $render = new SassRenderer();
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $sass_name, $attrs);
    }
}

if (!function_exists('sassd')) {
    function sassd(string $sass_name, array $attrs = []): void
    {
        $render = new SassRenderer(false);
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $sass_name, $attrs);
    }
}

if (!function_exists('scss')) {
    function scss(string $scss_name, array $attrs = []): void
    {
        $render = new ScssRenderer();
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $scss_name, $attrs);
    }
}

if (!function_exists('scssd')) {
    function scssd(string $scss_name, array $attrs = []): void
    {
        $render = new ScssRenderer(false);
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $scss_name, $attrs);
    }
}

if (!function_exists('js')) {
    function js(string $js_name, array $attrs = []): void
    {
        $render = new JsRenderer();
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $js_name, $attrs);
    }
}

if (!function_exists('jsd')) {
    function jsd(string $js_name, array $attrs = []): void
    {
        $render = new JsRenderer(false);
        $render->render(App::get()->config(), Controller::cast(App::get()->controller()), $js_name, $attrs);
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

if (!function_exists('etdir')) {
    function etdir(string $filename): void
    {
        if ($filename !== '') {
            $path = ($filename[0] === '/' ? $filename : '/' . $filename);
            eu(get_template_directory_uri() . $path);
        }
    }
}

if (!function_exists('ne')) {
    function ne(string|Stringable|null $value, string $if_null): void
    {
        if (is_null($value)) {
            echo $if_null;
        } else {
            echo $value;
        }
    }
}

if (!function_exists('nea')) {
    function nea(string|Stringable|null $value, string $if_null): void
    {
        if (is_null($value)) {
            ea($if_null);
        } else {
            ea($value);
        }
    }
}

if (!function_exists('neh')) {
    function neh(string|Stringable|null $value, string $if_null): void
    {
        if (is_null($value)) {
            eh($if_null);
        } else {
            eh($value);
        }
    }
}

if (!function_exists('neu')) {
    function neu(string|Stringable|null $value, string $if_null): void
    {
        if (is_null($value)) {
            eu($if_null);
        } else {
            eu($value);
        }
    }
}
