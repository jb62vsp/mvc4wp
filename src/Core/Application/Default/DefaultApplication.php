<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application\Default;

use Mvc4Wp\Core\Application\ApplicationInterface;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Controller\ControllerInterface;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\HttpStatus;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Library\ClockInterface;
use Mvc4Wp\Core\Route\RouteHandler;
use Mvc4Wp\Core\Route\RouterInterface;
use Mvc4Wp\Core\Service\Logging;

class DefaultApplication implements ApplicationInterface
{
    use Castable;

    protected RouterInterface $_router;

    protected ClockInterface $_clock;

    protected ControllerInterface $_controller;

    protected string $errorHandlerClass;

    public function __construct(
        protected readonly ConfiguratorInterface $_config,
    ) {
        $routerFactory = new($this->_config->get('FACTORY', 'router'))();
        $this->_router = $routerFactory->create();

        $defaultHandler = $this->_config->get('ERROR_HANDLERS', 'default_handler_name');
        $this->errorHandlerClass = $this->_config->get('ERROR_HANDLERS', 'handlers', $defaultHandler);
    }

    public function config(): ConfiguratorInterface
    {
        return $this->_config;
    }

    public function router(): RouterInterface
    {
        return $this->_router;
    }

    public function clock(): ClockInterface
    {
        return $this->_clock;
    }

    public function controller(): ControllerInterface
    {
        return $this->_controller;
    }

    public function run(): void
    {
        try {
            $request_method = strtoupper($_SERVER['REQUEST_METHOD']);
            if (isset($_POST['_method'])) {
                $request_method = strtoupper($_POST['_method']);
            } elseif (isset($_POST['_METHOD'])) {
                $request_method = strtoupper($_POST['_METHOD']);
            }

            /** @var RouteHandler $route */
            $route = $this->_router->dispatch($this->_config, $request_method, $_SERVER['REQUEST_URI']);

            if ($route->status !== HttpStatus::OK) {
                $cls = $this->_config->get('ERROR_HANDLERS', 'handlers', strval($route->status->value));
                if (!is_null($cls)) {
                    $this->errorHandlerClass = $cls;
                }
                /** @var ControllerInterface $controller */
                $controller = new $this->errorHandlerClass($this->_config);
                $controller->init([$route->status]);
                $controller->index([$route->status]);
                return;
            }
            if (!class_exists($route->class)) {
                throw new ApplicationException(); // TODO:
            }

            /** @var ControllerInterface $controller */
            $controller = new $route->class($this->config());
            $this->_controller = $controller;
            if (!method_exists($controller, $route->method)) {
                throw new ApplicationException(); // TODO:
            }

            if (method_exists($controller, 'init')) {
                Logging::get('core')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '::init', $route->args);
                $controller->init($route->args);
            }

            Logging::get('core')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '::' . $route->method, $route->args);
            $controller->{$route->method}($route->args);
        } catch (ApplicationException $ex) {
            Logging::get('core')->error($ex->getMessage(), [$ex]);
            /** @var ControllerInterface $controller */
            $controller = new $this->errorHandlerClass($this->_config, HttpStatus::INTERNAL_SERVER_ERROR);
            $controller->init();
            $controller->index();
            return;
        }
    }
}