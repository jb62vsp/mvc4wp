<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application\Default;

use Mvc4Wp\Core\Application\ApplicationInterface;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Controller\ControllerInterface;
use Mvc4Wp\Core\Controller\Default\DefaultErrorController;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\HttpStatus;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Library\ClockInterface;
use Mvc4Wp\Core\Library\Default\DefaultClockFactory;
use Mvc4Wp\Core\Route\Default\DefaultRouterFactory;
use Mvc4Wp\Core\Route\RouteHandler;
use Mvc4Wp\Core\Route\RouterInterface;
use Mvc4Wp\Core\Service\Logging;

class DefaultApplication implements ApplicationInterface
{
    use Castable;

    protected RouterInterface $_router;

    protected ClockInterface $_clock;

    protected ControllerInterface $_controller;

    protected ControllerInterface $_errorHandler;

    public function __construct(
        protected readonly ConfiguratorInterface $_config,
    ) {
    }

    public function config(): ConfiguratorInterface
    {
        return $this->_config;
    }

    public function router(): RouterInterface
    {
        if (!isset($this->_router)) {
            $routerFactoryClass = $this->_config->get('FACTORY', 'router');
            if (is_null($routerFactoryClass) || class_exists($routerFactoryClass)) {
                $routerFactoryClass = DefaultRouterFactory::class;
            }
            $this->_router = (new $routerFactoryClass())->create();
        }
        return $this->_router;
    }

    public function clock(): ClockInterface
    {
        $clockFactoryClass = $this->config()->get('FACTORY', 'clock');
        if (is_null($clockFactoryClass) || class_exists($clockFactoryClass)) {
            $clockFactoryClass = DefaultClockFactory::class;
        }
        $this->_clock = (new $clockFactoryClass())->create();

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
            $route = $this->router()->dispatch($this->config(), $request_method, $_SERVER['REQUEST_URI']);

            if ($route->status !== HttpStatus::OK) {
                $errorHandler = $this->errorHandler();
                $errorHandler->init([$route->status]);
                $errorHandler->index([$route->status]);
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
            $errorHandler = $this->errorHandler();
            $errorHandler->init([HttpStatus::INTERNAL_SERVER_ERROR]);
            $errorHandler->index([HttpStatus::INTERNAL_SERVER_ERROR]);
            return;
        }
    }

    protected function errorHandler(): ControllerInterface
    {
        if (!isset($this->_errorHandler)) {
            $errorHandlerClass = DefaultErrorController::class;

            $defaultHandlerName = $this->config()->get('ERROR_HANDLERS', 'default_handler_name');
            if (!is_null($defaultHandlerName)) {
                $defaultErrorHandlerClass = $this->config()->get('ERROR_HANDLERS', 'handlers', $defaultHandlerName);
                if (!is_null($defaultErrorHandlerClass) && class_exists($defaultErrorHandlerClass)) {
                    $errorHandlerClass = $defaultErrorHandlerClass;
                }
            }
            $this->_errorHandler = new $errorHandlerClass($this->config());
        }

        return $this->_errorHandler;
    }
}