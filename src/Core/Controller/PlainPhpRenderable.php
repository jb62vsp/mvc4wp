<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Exception\ApplicationException;

trait PlainPhpRenderable
{
    private bool $first = true;

    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        if ($this->first) {
            $responder->header('Content-Type: text/html; charset=utf-8');
            $this->first = false;
        }

        $view_path = $config->get('view_directory') . DIRECTORY_SEPARATOR . $view . '.php';
        if (file_exists($view_path)) {
            debug_view_start($view_path);
            include $view_path;
            debug_view_end($view_path, $data);
        } else {
            throw new ApplicationException('view not found: ' . $view_path);
        }

        return $this;
    }
}