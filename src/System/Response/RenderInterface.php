<?php declare(strict_types=1);
namespace System\Response;

use System\Config\ConfigInterface;

interface RenderInterface
{
    public function render(ConfigInterface $config, string $view_name, array $data = []): self;
}