<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use MatthiasMullie\Minify\JS;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Service\Logging;

trait JsRenderable
{
    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        debug_view_start($view . '.js');

        try {
            echo '<script>';
            if ($config->get('js.use_minify') === 'true') {
                $this->renderMinJs($config, $view);
            } else {
                $this->renderJs($config, $view);
            }
        } finally {
            echo '</script>';
        }

        debug_view_end($view . '.js', $data);

        return $this;
    }

    protected function renderMinJs(ConfiguratorInterface $config, string $view): void
    {
        $minjs_path = $config->get('js.js_directory') . DIRECTORY_SEPARATOR . $view . '.min.js';

        if (!file_exists($minjs_path)) {
            $this->renderJs($config, $view);
        }

        if (!file_exists($minjs_path)) {
            throw new ApplicationException('view not found: ' . $minjs_path);
        }

        echo file_get_contents($minjs_path);
    }

    protected function renderJs(ConfiguratorInterface $config, string $view): void
    {
        $js_path = $config->get('js.js_directory') . DIRECTORY_SEPARATOR . $view . '.js';

        if (!file_exists($js_path)) {
            throw new ApplicationException('view not found: ' . $js_path);
        }

        if ($config->get('js.use_minify') === 'true') {
            $minifier = new JS($js_path);
            $minjs_path = $config->get('js.js_directory') . DIRECTORY_SEPARATOR . $view . '.min.js';
            $minifier->minify($minjs_path);
            Logging::get('core')->info("js minified: {$js_path} -> {$minjs_path}");
        } else {
            echo file_get_contents($js_path);
        }
    }
}