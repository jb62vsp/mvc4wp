<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controllers;

use Mvc4Wp\System\Config\ConfigInterface;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Response\RenderInterface;
use Mvc4Wp\System\Response\ResponderInterface;
use Mvc4Wp\System\Service\Logging;

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