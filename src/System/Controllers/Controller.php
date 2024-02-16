<?php declare(strict_types=1);
namespace System\Controllers;

use System\Config\ConfigInterface;
use System\Core\Cast;
use System\Response\RenderInterface;
use System\Response\ResponderInterface;

abstract class Controller implements RenderInterface, ResponderInterface
{
    use Cast;

    public function __construct(
        public ConfigInterface $config
    ) {
    }

    public function view(string $view_name, array $data = []): static
    {
        return $this->render($this->config, $this->responder(), $view_name, $data);
    }
}