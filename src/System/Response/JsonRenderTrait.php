<?php declare(strict_types=1);
namespace System\Response;

use System\Config\ConfigInterface;

trait JsonRenderTrait
{

    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self
    {
        $responder->header('Content-Type: text/json; charset=utf-8');
        echo $view;
        return $this;
    }
}