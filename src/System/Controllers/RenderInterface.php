<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controllers;

use Mvc4Wp\System\Config\ConfigInterface;

interface RenderInterface
{
    public function render(ConfigInterface $config, ResponderInterface $responder, string $view, array $data = []): self;
}