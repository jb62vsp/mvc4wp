<?php declare(strict_types=1);
namespace Wp4Mvc\System\Response;

use Wp4Mvc\System\Config\ConfigInterface;

interface RenderInterface
{
    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self;
}