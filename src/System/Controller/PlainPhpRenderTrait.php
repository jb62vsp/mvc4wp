<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controller;

use Mvc4Wp\System\Config\ConfigInterface;
use Mvc4Wp\System\Exception\ApplicationException;

trait PlainPhpRenderTrait
{
    private bool $first = true;

    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        if ($this->first) {
            $responder->header('Content-Type: text/html; charset=utf-8');
            $this->first = false;
        }
        $view_path = $config->get('VIEW_DIRECTORY') . DIRECTORY_SEPARATOR . $view . '.php';
        if (file_exists($view_path)) {
            include $view_path;
        } else {
            throw new ApplicationException('view not found: ' . $view_path);
        }
        return $this;
    }
}