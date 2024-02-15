<?php declare(strict_types=1);
namespace System\Response;

use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Exception\ApplicationException;

trait PlainPhpRenderTrait
{
    private bool $first = true;

    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        if ($this->first) {
            $responder->header('Content-Type: text/html; charset=utf-8');
            $this->first = false;
        }
        $view_path = $config->getConfig(CONFIG::VIEW_DIRECTORY) . DIRECTORY_SEPARATOR . $view . '.php';
        if (file_exists($view_path)) {
            include $view_path;
        } else {
            throw new ApplicationException('view not found.');
        }
        return $this;
    }
}