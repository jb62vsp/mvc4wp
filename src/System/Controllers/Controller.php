<?php declare(strict_types=1);
namespace System\Controllers;

use System\Config\ConfigInterface;
use System\Core\Cast;
use System\Response\RenderInterface;
use System\Response\ResponderInterface;
use System\Response\ResponderTrait;

abstract class Controller implements RenderInterface, ResponderInterface
{
    use Cast, ResponderTrait;

    public function __construct(
        public ConfigInterface $config
    ) {
    }

    public function view(string $view_name, array $data = []): self
    {
        return $this->render($this->config, $this->responder(), $view_name, $data);
    }
}