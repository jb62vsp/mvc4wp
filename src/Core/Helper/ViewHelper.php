<?php

declare(strict_types=1);

use Mvc4Wp\Core\Controller\Controller;
use Mvc4Wp\Core\Controller\CssRenderer;
use Mvc4Wp\Core\Controller\JsRenderer;
use Mvc4Wp\Core\Controller\SassRenderer;
use Mvc4Wp\Core\Controller\ScssRenderer;
use Mvc4Wp\Core\Service\App;

// -- render

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

// -- echo

if (!function_exists('ea')) {
    /**
     * Syntax sugar to esc_attr.
     * @param mixed $value
     * @param bool $return
     *   true: no echo and return escaped value.
     *  false: echo escaped value and return null.
     * @return string|null
     */
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
    /**
     * Syntax sugar to esc_html.
     * @param mixed $value
     * @param bool $return
     *   true: no echo and return escaped value.
     *  false: echo escaped value and return null.
     * @return string|null
     */
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
    /**
     * Syntax sugar to esc_url.
     * @param mixed $value
     * @param bool $return
     *   true: no echo and return escaped value.
     *  false: echo escaped value and return null.
     * @return string|null
     */
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

if (!function_exists('create_path')) {
    /**
     * Create path.
     * @param string $filename
     * @param mixed $return
     *   true: no echo and return created value.
     *  false: echo created value and return null.
     * @return string|null
     */
    function create_path(string $filename, $return = false): string|null
    {
        if ($filename !== '') {
            $t = get_template_directory_uri();
            return eu($t . ($filename[0] === '/' ? $filename : '/' . $filename), $return);
        }

        return eu('', $return);
    }
}

if (!function_exists('ifnull')) {
    /**
     * Syntax sugar to ternary operator.
     * @param string|Stringable|null $value
     * @param string $if_null
     * @return string|Stringable|null
     */
    function ifnull(string|Stringable|null $value, string $if_null): string
    {
        return is_null($value) ? $if_null : $value;
    }
}
