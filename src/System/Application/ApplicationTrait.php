<?php declare(strict_types=1);
namespace Wp4Mvc\System\Application;

use Wp4Mvc\System\Config\ConfigInterface;
use Wp4Mvc\System\Controllers\HttpErrorController;
use Wp4Mvc\System\Core\HttpStatus;
use Wp4Mvc\System\Exception\ApplicationException;
use Wp4Mvc\System\Route\RouteHandler;
use Wp4Mvc\System\Route\RouterInterface;
use Wp4Mvc\System\Service\Locator;
use Wp4Mvc\System\Service\Logging;

trait ApplicationTrait
{
    protected ConfigInterface $config;

    protected RouterInterface $router;

    public function config(): ConfigInterface
    {
        return $this->config;
    }

    public function router(): RouterInterface
    {
        return $this->router;
    }

    protected function executeController(ConfigInterface $config, RouterInterface $router): void
    {
        try {
            $request_method = strtoupper($_SERVER['REQUEST_METHOD']);
            if (isset($_POST['_method'])) {
                $request_method = strtoupper($_POST['_method']);
            } elseif (isset($_POST['_METHOD'])) {
                $request_method = strtoupper($_POST['_METHOD']);
            }

            /** @var RouteHandler $route */
            $route = $router->dispatch($config, $request_method, $_SERVER['REQUEST_URI']);

            if ($route->status !== HttpStatus::OK) {
                $controller = new HttpErrorController($config, $route->status); // TODO: error controller define config
                $controller->index();
                return;
            }

            if (!class_exists($route->class)) {
                throw new ApplicationException();
            }

            $controller = new $route->class($this->config());
            Locator::setController($controller);
            if (!method_exists($controller, $route->method)) {
                throw new ApplicationException();
            }

            if (method_exists($controller, 'init')) {
                Logging::get('system')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '->init', $route->args);
                $controller->init($route->args);
            }

            Logging::get('system')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '->' . $route->method, $route->args);
            $controller->{$route->method}($route->args);
        } catch (ApplicationException $ex) {
            Logging::get('system')->error($ex->getMessage(), [$ex]);
            $controller = new HttpErrorController($config, HttpStatus::INTERNAL_SERVER_ERROR); // TODO: error controller define config
            $controller->index();
            return;
        }
    }

    abstract public function run(): void;
}