<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Debug;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Controller\HttpRespondable;
use Mvc4Wp\Core\Controller\RenderInterface;
use Mvc4Wp\Core\Controller\ResponderInterface;
use Mvc4Wp\Core\Exception\ApplicationException;
use ScssPhp\ScssPhp\Compiler;

class DebugScssRenderer implements RenderInterface, ResponderInterface
{
    use HttpRespondable;

    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        if ($config->get('debug') === 'true') {
            $core_root = $config->get('core_root');
            $scss_path = $core_root . '/View/debug/' . $view;

            if (!file_exists($scss_path)) {
                throw new ApplicationException('view not found: ' . $scss_path);
            }

            $scss = new Compiler();
            $compiled = $scss->compileFile($scss_path);
            echo $compiled->getCss();
        }
        return $this;
    }
}