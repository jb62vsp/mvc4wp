<?php declare(strict_types=1);
namespace System\Application;

use System\Config\ConfigInterface;
use System\Config\DefaultConfigurator;
use System\Controllers\DefaultHttpErrorController;
use System\Core\Cast;
use System\Core\HttpStatus;
use System\Exception\ApplicationException;
use System\Route\DefaultRouter;
use System\Route\RouteHandler;
use System\Route\RouterInterface;
use System\Service\Logging;

final class Application implements ApplicationInterface
{
    use Cast;

    public function __construct(
        private ConfigInterface $config = new DefaultConfigurator(),
        private RouterInterface $router = new DefaultRouter(),
    ) {
        /*
         * -------- DEFAULT CONFIGURATIONS --------
         */
        $this->config()->add(\System\Config\CONFIG::DEBUG, 'false');
        $this->config()->add(\System\Config\CONFIG::LOGGER, [
            'default_logger_name' => 'app',
            'loggers' => [
                'app' => [
                    'logger_factory' => '\System\Logger\FileLoggerFactory',
                    'directory' => __WPMVC_ROOT__ . '/log/',
                    'basefilename' => 'app',
                    'date_format' => 'Ymd',
                    'log_level' => 'debug',
                ],
                'system' => [
                    'logger_factory' => '\System\Logger\FileLoggerFactory',
                    'directory' => __WPMVC_ROOT__ . '/log/',
                    'basefilename' => 'sys',
                    'date_format' => 'Ymd',
                    'log_level' => 'debug',
                ],
            ],
        ]);
        $this->config()->add(\System\Config\CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
        $this->config()->add(\System\Config\CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');
    }

    public function config(): ConfigInterface
    {
        return $this->config;
    }

    public function router(): RouterInterface
    {
        return $this->router;
    }

    public function run(): void
    {
        include_once(__WPMVC_ROOT__ . '/src/System/Core/Common.php');
        $this->execute($this->config(), $this->router());
    }

    public function execute(ConfigInterface $config, RouterInterface $router): void
    {
        $request_method = strtoupper($_SERVER['REQUEST_METHOD']);
        if (isset($_POST['_method'])) {
            $request_method = strtoupper($_POST['_method']);
        } elseif (isset($_POST['_METHOD'])) {
            $request_method = strtoupper($_POST['_METHOD']);
        }

        /** @var RouteHandler $route */
        $route = $router->dispatch($config, $request_method, $_SERVER['REQUEST_URI']);

        if ($route->status !== HttpStatus::OK) {
            $controller = new DefaultHttpErrorController($config, $route->status);
            $controller->index();
            return;
        }

        if (!class_exists($route->class)) {
            throw new ApplicationException();
        }

        $controller = new $route->class($this->config());
        if (!method_exists($controller, $route->method)) {
            throw new ApplicationException();
        }

        if (method_exists($controller, 'init')) {
            Logging::get('system')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '->init', $route->args);
            $controller->init($route->args);
        }

        Logging::get('system')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '->' . $route->method, $route->args);
        $controller->{$route->method}($route->args);
    }
}