<?php declare(strict_types=1);
namespace System\Controllers;

use System\Config\ConfigInterface;
use System\Core\Cast;
use System\Response\RenderInterface;
use System\Response\ResponderInterface;
use System\Service\Logging;

abstract class Controller implements RenderInterface, ResponderInterface
{
    use Cast;

    public function __construct(
        public ConfigInterface $config
    ) {
    }

    public function view(string $view_name, array $data = []): static
    {
        Logging::get('system')->debug('load view: ' . $view_name, $data);
        return $this->render($this->config, $this->responder(), $view_name, $data);
    }

    abstract public function init(array $args = []): void;

    abstract public function index(array $args = []): void;
}