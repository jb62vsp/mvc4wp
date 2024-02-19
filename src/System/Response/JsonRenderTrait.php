<?php declare(strict_types=1);
namespace Wp4Mvc\System\Response;

use Wp4Mvc\System\Config\ConfigInterface;
use Wp4Mvc\System\Core\Cast;

trait JsonRenderTrait
{
    use Cast, DefaultResponder;

    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        $responder->header('Content-Type: text/json; charset=utf-8');
        echo $view;
        return $this;
    }
}