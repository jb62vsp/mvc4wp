<?php declare(strict_types=1);
namespace System\Response;

use System\Config\CONFIG;
use System\Config\ConfigInterface;

trait PlainPhpRenderTrait
{

    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        $responder->header('Content-Type: text/html; charset=utf-8');
        $view_path = $config->getConfig(CONFIG::VIEW_DIRECTORY) . DIRECTORY_SEPARATOR . $view . '.php';
        if (file_exists($view_path)) {
            include_once $view_path;
        }
        return $this;
    }
}