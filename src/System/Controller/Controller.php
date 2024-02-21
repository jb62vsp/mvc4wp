<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controller;

use Mvc4Wp\System\Config\ConfiguratorInterface;
use Mvc4Wp\System\Library\Cast;
use Mvc4Wp\System\Service\Logging;

abstract class Controller implements ControllerInterface, RenderInterface, ResponderInterface
{
    use Cast;

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