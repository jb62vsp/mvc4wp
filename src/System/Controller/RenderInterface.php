<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controller;

use Mvc4Wp\System\Config\ConfiguratorInterface;

interface RenderInterface
{
    public function render(ConfiguratorInterface $config, ResponderInterface $responder, string $view, array $data = []): self;
}