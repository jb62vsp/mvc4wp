<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Debug;

use Exception;
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
        if (is_debug()) {
            $core_root = $config->get('core_root');
            $scss_path = $core_root . '/View/debug/' . $view;

            if (!file_exists($scss_path)) {
                throw new ApplicationException('view not found: ' . $scss_path);
            }

            $scss = new Compiler();
            try {
                $compiled = $scss->compileFile($scss_path);
            } catch (Exception $ex) {
                throw new ApplicationException('SCSS compile error', 0, $ex);
            }
            echo $compiled->getCss();
        }
        return $this;
    }
}