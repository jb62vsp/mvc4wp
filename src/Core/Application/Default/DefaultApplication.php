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
            $routerFactoryClass = DefaultRouterFactory::class;

            $customRouterFactoryClass = $this->_config->get('factory.router');
            if (!is_null($customRouterFactoryClass) && class_exists($customRouterFactoryClass)) {
                $routerFactoryClass = $customRouterFactoryClass;
            }
            $this->_router = $routerFactoryClass::create();
        }
        return $this->_router;
    }

    public function clock(): ClockInterface
    {
        $clockFactoryClass = DefaultClockFactory::class;

        $customClockFactoryClass = $this->config()->get('factory.clock');
        if (!is_null($customClockFactoryClass) && class_exists($customClockFactoryClass)) {
            $clockFactoryClass = $customClockFactoryClass;
        }
        $this->_clock = $clockFactoryClass::create();

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
                $errorHandler = $this->errorHandler($route->status);
                Logging::get('core')->debug(sprintf('[%d] "%s" => %s::index', $route->status->value, $_SERVER['REQUEST_URI'], get_class($errorHandler)), $route->args);
                Logging::get('core')->notice(sprintf('[%d] "%s"', $route->status->value, $_SERVER['REQUEST_URI']));
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
            $errorHandler = $this->errorHandler(HttpStatus::INTERNAL_SERVER_ERROR);
            $errorHandler->init([HttpStatus::INTERNAL_SERVER_ERROR]);
            $errorHandler->index([HttpStatus::INTERNAL_SERVER_ERROR]);
            return;
        }
    }

    protected function errorHandler(HttpStatus $httpStatus): ControllerInterface
    {
        $errorHandlerClass = DefaultErrorController::class;

        $customErrorHandlerClass = $this->config()->get('error_handler.handlers.' . strval($httpStatus->value));
        if (!is_null($customErrorHandlerClass) && class_exists($customErrorHandlerClass)) {
            $errorHandlerClass = $customErrorHandlerClass;
        } else {
            $defaultHandlerName = $this->config()->get('error_handler.default_handler_name');
            if (!is_null($defaultHandlerName)) {
                $defaultErrorHandlerClass = $this->config()->get('error_handler.handlers.' . $defaultHandlerName);
                if (!is_null($defaultErrorHandlerClass) && class_exists($defaultErrorHandlerClass)) {
                    $errorHandlerClass = $defaultErrorHandlerClass;
                }
            }
        }

        return new $errorHandlerClass($this->config());
    }
}