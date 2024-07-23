<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Exception;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Service\Logging;

trait SassRenderable
{
    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        debug_view_start($view . '.sass');

        try {
            echo '<style>';
            if ($config->get('css.use_cache') === 'true') {
                $this->renderCss($config, $view);
            } else {
                $this->renderSass($config, $view);
            }
        } finally {
            echo '</style>';
        }

        debug_view_end($view . '.sass', $data);

        return $this;
    }

    protected function renderSass(ConfiguratorInterface $config, string $view): void
    {
        $sass_path = $config->get('css.sass_directory') . DIRECTORY_SEPARATOR . $view . '.sass';
        $css_path = $config->get('css.css_directory') . DIRECTORY_SEPARATOR . $view . '.css';

        if (!file_exists($sass_path)) {
            throw new ApplicationException('view not found: ' . $sass_path);
        }

        $exec_path = $config->get('css.sass_path');
        $sass_args = $config->get('css.sass_args');

        $cmd = [];
        $cmd[] = $exec_path;
        if ($config->get('css.use_minify') === 'true') {
            $cmd[] = '--style=compressed';
        }
        $cmd[] = $sass_args;
        $cmd[] = $sass_path;
        if ($config->get('css.use_cache') === 'true') {
            $cmd[] = $css_path;
        }
        $cmd[] = ' 2>&1';

        $command = implode(" ", $cmd);
        $output = [];
        $result_code = 0;

        try {
            exec($command, $output, $result_code);
            if ($result_code !== 0) {
                throw new ApplicationException(implode(' ', $output), $result_code);
            }
        } catch (Exception $ex) {
            throw new ApplicationException('SASS compile error', $ex->getCode(), $ex);
        }
        if ($config->get('css.use_cache') === 'true') {
            Logging::get('core')->info("sass cached: {$sass_path} -> {$css_path}");
        } else {
            $css = implode("\n", $output);
            echo $css;
        }
    }

    protected function renderCss(ConfiguratorInterface $config, string $view): void
    {
        $css_path = $config->get('css.css_directory') . DIRECTORY_SEPARATOR . $view . '.css';

        if (!file_exists($css_path)) {
            $this->renderSass($config, $view);
        }

        if (!file_exists($css_path)) {
            throw new ApplicationException('view not found: ' . $css_path);
        }

        echo file_get_contents($css_path);
    }
}