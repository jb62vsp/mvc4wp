<?php declare(strict_types=1);
namespace Wp4Mvc\System\Response;

use Wp4Mvc\System\Config\CONFIG;
use Wp4Mvc\System\Config\ConfigInterface;
use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Exception\ApplicationException;

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
            throw new ApplicationException('view not found: ' . $view_path);
        }
        return $this;
    }
}