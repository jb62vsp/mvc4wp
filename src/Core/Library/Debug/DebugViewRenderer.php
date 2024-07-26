<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Debug;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Controller\HttpRespondable;
use Mvc4Wp\Core\Controller\RenderInterface;
use Mvc4Wp\Core\Controller\ResponderInterface;
use Mvc4Wp\Core\Exception\ApplicationException;

class DebugViewRenderer implements RenderInterface, ResponderInterface
{
    use HttpRespondable;

    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): static
    {
        if (is_debug()) {
            $core_root = $config->get('core_root');
            $view_path = $core_root . '/View/debug/' . $view;
            if (file_exists($view_path)) {
                include $view_path;
            } else {
                throw new ApplicationException('view not found: ' . $view_path);
            }
        }
        return $this;
    }
}