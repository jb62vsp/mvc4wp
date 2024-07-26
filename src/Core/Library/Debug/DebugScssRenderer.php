<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Debug;

use Exception;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Controller\HttpRespondable;
use Mvc4Wp\Core\Controller\RenderInterface;
use Mvc4Wp\Core\Controller\ResponderInterface;
use Mvc4Wp\Core\Exception\ApplicationException;

class DebugScssRenderer implements RenderInterface, ResponderInterface
{
    use HttpRespondable;

    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): static
    {
        if (is_debug()) {
            $core_root = $config->get('core_root');
            $scss_path = $core_root . '/View/debug/' . $view;

            if (!file_exists($scss_path)) {
                throw new ApplicationException('view not found: ' . $scss_path);
            }

            $sass_path = $config->get('css.sass_path');
            $cmd = $sass_path . ' ' . $scss_path . ' 2>&1';
            $output = [];
            $result_code = 0;

            try {
                exec($cmd, $output, $result_code);
                if ($result_code !== 0) {
                    throw new ApplicationException(implode(' ', $output), $result_code);
                }
            } catch (Exception $ex) {
                throw new ApplicationException('SCSS compile error', $ex->getCode(), $ex);
            }
            $css = implode("\n", $output);
            echo $css;
        }
        return $this;
    }
}