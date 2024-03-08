<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Exception\ApplicationException;

trait CssRenderable
{
    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        debug_view_start($view . '.css');

        $this->renderCss($config, $view);

        debug_view_end($view . '.css', $data);

        return $this;
    }

    protected function renderCss(ConfiguratorInterface $config, string $view)
    {
        $css_path = $config->get('css.css_directory') . DIRECTORY_SEPARATOR . $view . '.css';

        if (!file_exists($css_path)) {
            throw new ApplicationException('view not found: ' . $css_path);
        }

        echo file_get_contents($css_path);
    }
}