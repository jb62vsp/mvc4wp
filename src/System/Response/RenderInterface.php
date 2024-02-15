<?php declare(strict_types=1);
namespace System\Response;

use System\Config\ConfigInterface;

interface RenderInterface
{
    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self;
}