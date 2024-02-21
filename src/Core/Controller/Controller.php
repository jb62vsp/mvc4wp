<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Service\Logging;

abstract class Controller implements ControllerInterface, RenderInterface, ResponderInterface
{
    use Castable;

    public function __construct(
        protected ConfiguratorInterface $config
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