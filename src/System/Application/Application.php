<?php declare(strict_types=1);
namespace System\Application;

use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Config\DefaultConfigurator;
use System\Core\Cast;
use System\Core\HttpStatus;
use System\Route\RouteHandler;
use System\Route\RouterInterface;
use System\Route\RouterTrait;

final class Application implements ApplicationInterface, RouterInterface
{
    use Cast, RouterTrait;

    public function __construct(
        private ConfigInterface $config = new DefaultConfigurator(),
    ) {
        /*
         * -------- DEFAULT CONFIGURATIONS --------
         */
        $this->config()->addConfig(CONFIG::DEBUG, 'false');
        $this->config()->addConfig(CONFIG::BOOTSTRAP, __WPMVC_ROOT__ . '/src/App/bootstrap.php');
        $this->config()->addConfig(CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
        $this->config()->addConfig(CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');
    }

    public function config(): ConfigInterface
    {
        return $this->config;
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
            return; // TODO:
        }

        $signatures = explode('::', $route->signature);
        if (count($signatures) !== 2) {
            return; // TODO:
        }

        $class = $signatures[0];
        if (!class_exists($class)) {
            return; // TODO:
        }

        $controller = new $class($this->config());
        $method = $signatures[1];
        if (!method_exists($controller, $method)) {
            return; // TODO:
        }

        if (method_exists($controller, 'init')) {
            $controller->init();
        }

        $controller->{$method}($route->args);
    }
}