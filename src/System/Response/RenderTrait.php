<?php declare(strict_types=1);
namespace System\Response;

use System\Config\CONFIG;
use System\Config\ConfigInterface;

trait RenderTrait
{

    public function render(ConfigInterface $config, string $view_name, array $data = []): self
    {
        $view_path = $config->getConfig(CONFIG::VIEW_DIRECTORY) . '/' . $view_name . '.php';
        if (file_exists($view_path)) {
            include_once $view_path;
        }
        return $this;
    }
}