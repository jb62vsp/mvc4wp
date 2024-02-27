<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Service\Logging;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

trait ScssRenderable
{
    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        if ($config->get('scss.use_cache') === 'true') {
            $this->renderCss($config, $view);
        } else {
            $this->renderScss($config, $view);
        }

        return $this;
    }

    protected function renderScss(ConfiguratorInterface $config, string $view)
    {
        $scss_path = $config->get('scss.scss_directory') . DIRECTORY_SEPARATOR . $view . '.scss';

        if (!file_exists($scss_path)) {
            throw new ApplicationException('view not found: ' . $scss_path);
        }

        $scss = new Compiler();
        $scss->setOutputStyle(OutputStyle::COMPRESSED);
        $compiled = $scss->compileFile($scss_path);

        if ($config->get('scss.use_cache') === 'true') {
            $css_path = $config->get('scss.css_directory') . DIRECTORY_SEPARATOR . $view . '.css';
            file_put_contents($css_path, $compiled->getCss(), LOCK_EX);
            Logging::get('core')->info("scss cached: {$scss_path} -> {$css_path}");
        } else {
            echo $compiled->getCss();
        }
    }

    protected function renderCss(ConfiguratorInterface $config, string $view)
    {
        $css_path = $config->get('scss.css_directory') . DIRECTORY_SEPARATOR . $view . '.css';

        if (!file_exists($css_path)) {
            $this->renderScss($config, $view);
        }

        if (!file_exists($css_path)) {
            throw new ApplicationException('view not found: ' . $css_path);
        }

        echo file_get_contents($css_path);
    }
}