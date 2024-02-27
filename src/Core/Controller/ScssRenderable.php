<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Service\Logging;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

trait ScssRenderable
{
    public bool $use_cache = false;

    protected ConfiguratorInterface $config;

    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        $this->config = $config;

        if ($this->use_cache) {
            $this->renderCss($view);
        } else {
            $this->renderScss($view);
        }

        return $this;
    }

    protected function renderScss(string $view)
    {
        $scss_path = $this->config->get('view_directory') . DIRECTORY_SEPARATOR . $view . '.scss';

        if (!file_exists($scss_path)) {
            throw new ApplicationException('view not found: ' . $scss_path);
        }

        $scss = new Compiler();
        $scss->setOutputStyle(OutputStyle::COMPRESSED);
        $compiled = $scss->compileFile($scss_path);

        if ($this->use_cache) {
            $css_path = $this->config->get('view_directory') . DIRECTORY_SEPARATOR . $view . '.css';
            file_put_contents($css_path, $compiled->getCss(), LOCK_EX);
            Logging::get('core')->info("scss cached: {$scss_path} -> {$css_path}");
        } else {
            echo $compiled->getCss();
        }
    }

    protected function renderCss(string $view)
    {
        $css_path = $this->config->get('view_directory') . DIRECTORY_SEPARATOR . $view . '.css';

        if (!file_exists($css_path)) {
            $this->renderScss($view);
        }

        if (!file_exists($css_path)) {
            throw new ApplicationException('view not found: ' . $css_path);
        }

        echo file_get_contents($css_path);
    }
}