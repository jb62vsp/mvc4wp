<?php declare(strict_types=1);
namespace Wp4Mvc\System\Controllers;

use Wp4Mvc\System\Config\ConfigInterface;
use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Response\RenderInterface;
use Wp4Mvc\System\Response\ResponderInterface;
use Wp4Mvc\System\Service\Logging;

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