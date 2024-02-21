<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Config\ConfiguratorInterface;

interface RenderInterface
{
    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): self;
}