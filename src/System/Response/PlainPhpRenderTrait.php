<?php declare(strict_types=1);
namespace System\Response;

use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Core\Cast;
use System\Exception\ApplicationException;

trait PlainPhpRenderTrait
{
    use Cast;

    private bool $first = true;

    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        if ($this->first) {
            $responder->header('Content-Type: text/html; charset=utf-8');
            $this->first = false;
        }
        $view_path = $config->get(CONFIG::VIEW_DIRECTORY) . DIRECTORY_SEPARATOR . $view . '.php';
        if (file_exists($view_path)) {
            include $view_path;
        } else {
            throw new ApplicationException('view not found.');
        }
        return $this;
    }
}