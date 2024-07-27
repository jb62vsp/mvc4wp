<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application\Default;

use Error;
use Exception;
use Mvc4Wp\Core\Application\ApplicationInterface;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Controller\ControllerInterface;
use Mvc4Wp\Core\Controller\Default\DefaultErrorController;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Language\Default\DefaultMessagerFactory;
use Mvc4Wp\Core\Language\MessagerInterface;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Library\ClockInterface;
use Mvc4Wp\Core\Library\Default\DefaultClockFactory;
use Mvc4Wp\Core\Library\HttpStatus;
use Mvc4Wp\Core\Route\Default\DefaultRouterFactory;
use Mvc4Wp\Core\Route\RouteHandler;
use Mvc4Wp\Core\Route\RouterInterface;
use Mvc4Wp\Core\Service\Helper;
use Mvc4Wp\Core\Service\Logging;

class DefaultApplication implements ApplicationInterface
{
    use Castable;

    protected ClockInterface $_clock;

    protected ControllerInterface $_controller;

    protected MessagerInterface $_messager;

    protected RouterInterface $_router;

    public function __construct(
        protected readonly ConfiguratorInterface $_config,
    ) {
    }

    public function clock(): ClockInterface
    {
        if (!isset($this->_clock)) {
            $clock_factory = DefaultClockFactory::class;
            $custom_clock_factory = $this->config()->get('factory.clock');
            if (!is_null($custom_clock_factory) && class_exists($custom_clock_factory)) {
                $clock_factory = $custom_clock_factory;
            }
            $this->_clock = $clock_factory::create(['config' => $this->config()]);
        }

        return $this->_clock;
    }

    public function config(): ConfiguratorInterface
    {
        return $this->_config;
    }

    public function controller(): ControllerInterface
    {
        return $this->_controller;
    }

    public function errorHandler(HttpStatus $httpStatus): ControllerInterface
    {
        $error_handler = DefaultErrorController::class;

        $custom_error_handler = $this->config()->get('error_handler.handlers.' . strval($httpStatus->value));
        if (!is_null($custom_error_handler) && class_exists($custom_error_handler)) {
            $error_handler = $custom_error_handler;
        } else {
            $default_handler_name = $this->config()->get('error_handler.default_handler_name');
            if (!is_null($default_handler_name)) {
                $default_error_handler = $this->config()->get('error_handler.handlers.' . $default_handler_name);
                if (!is_null($default_error_handler) && class_exists($default_error_handler)) {
                    $error_handler = $default_error_handler;
                }
            }
        }

        return new $error_handler($this->config());
    }

    public function messager(): MessagerInterface
    {
        if (!isset($this->_messager)) {
            $messager_factory = DefaultMessagerFactory::class;
            $custom_messager_factory = $this->config()->get('factory.messager');
            if (!is_null($custom_messager_factory) && class_exists($custom_messager_factory)) {
                $messager_factory = $custom_messager_factory;
            }
            $this->_messager = $messager_factory::create(['config' => $this->config()]);
        }

        return $this->_messager;
    }

    public function router(): RouterInterface
    {
        if (!isset($this->_router)) {
            $router_factory = DefaultRouterFactory::class;
            $custom_router_factory = $this->config()->get('factory.router');
            if (!is_null($custom_router_factory) && class_exists($custom_router_factory)) {
                $router_factory = $custom_router_factory;
            }
            $this->_router = $router_factory::create(['config' => $this->config()]);
        }

        return $this->_router;
    }

    public function run(): void
    {
        try {
            Helper::load('NoDebug');

            $request_method = strtoupper($_SERVER['REQUEST_METHOD']);
            if (isset($_POST['_method'])) {
                $request_method = strtoupper($_POST['_method']);
            } elseif (isset($_POST['_METHOD'])) {
                $request_method = strtoupper($_POST['_METHOD']);
            }

            /** @var RouteHandler $route */
            $route = $this->router()->dispatch($this->config(), $request_method, $_SERVER['REQUEST_URI']);

            if ($route->status !== HttpStatus::OK) {
                $error_handler = $this->errorHandler($route->status);
                Logging::get('core')->debug(sprintf('[%d] "%s" => %s::index', $route->status->value, $_SERVER['REQUEST_URI'], get_class($error_handler)), $route->args);
                Logging::get('core')->notice(sprintf('[%d] "%s"', $route->status->value, $_SERVER['REQUEST_URI']));
                $error_handler->init([$route->status]);
                $error_handler->index([$route->status]);
                return;
            }

            if (!class_exists($route->class)) {
                throw new ApplicationException(sprintf('The class "%s" not exist.', $route->class));
            }

            /** @var ControllerInterface $controller */
            $controller = new $route->class($this->config());
            $this->_controller = $controller;
            if (!method_exists($controller, $route->method)) {
                throw new ApplicationException(sprintf('The method "%s::%s" not exist.', $route->class, $route->method));
            }

            if (method_exists($controller, 'init')) {
                Logging::get('core')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '::init', $route->args);
                $controller->init($route->args);
            }

            Logging::get('core')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '::' . $route->method, $route->args);
            $controller->{$route->method}($route->args);
        } catch (ApplicationException $ex) {
            debug_add('error', ['exception' => $ex]);
            Logging::get('core')->critical($ex->getMessage(), [$ex]);
            $error_handler = $this->errorHandler(HttpStatus::INTERNAL_SERVER_ERROR);
            $error_handler->init([HttpStatus::INTERNAL_SERVER_ERROR]);
            $error_handler->index([HttpStatus::INTERNAL_SERVER_ERROR]);
        } catch (Exception $ex) {
            debug_add('error', ['exception' => $ex]);
            Logging::get('core')->alert($ex->getMessage(), [$ex]);
            $error_handler = $this->errorHandler(HttpStatus::INTERNAL_SERVER_ERROR);
            $error_handler->init([HttpStatus::INTERNAL_SERVER_ERROR]);
            $error_handler->index([HttpStatus::INTERNAL_SERVER_ERROR]);
        } catch (Error $ex) {
            debug_add('error', ['exception' => $ex]);
            Logging::get('core')->emergency($ex->getMessage(), [$ex]);
            $error_handler = $this->errorHandler(HttpStatus::INTERNAL_SERVER_ERROR);
            $error_handler->init([HttpStatus::INTERNAL_SERVER_ERROR]);
            $error_handler->index([HttpStatus::INTERNAL_SERVER_ERROR]);
        } finally {
            debug_view();
        }
    }
}