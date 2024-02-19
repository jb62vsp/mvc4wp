<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controllers;

use Mvc4Wp\System\Config\ConfigInterface;
use Mvc4Wp\System\Core\Cast;

trait JsonRenderTrait
{
    use Cast, HttpResponder;

    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        $responder->header('Content-Type: text/json; charset=utf-8');
        echo $view;
        return $this;
    }
}