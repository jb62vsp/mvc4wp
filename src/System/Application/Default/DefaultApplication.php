<?php declare(strict_types=1);
namespace Mvc4Wp\System\Application\Default;

use Mvc4Wp\System\Application\AbstractApplication;
use Mvc4Wp\System\Config\ConfiguratorInterface;
use Mvc4Wp\System\Controller\ControllerInterface;
use Mvc4Wp\System\Controller\HttpErrorController;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Core\HttpStatus;
use Mvc4Wp\System\Exception\ApplicationException;
use Mvc4Wp\System\Route\RouteHandler;
use Mvc4Wp\System\Route\RouterInterface;
use Mvc4Wp\System\Service\Logging;

class DefaultApplication extends AbstractApplication
{
    use Cast;

    private ControllerInterface $controller;

    public function __construct(
        protected ConfiguratorInterface $config,
        protected RouterInterface $router,
    ) {
        $this->config = $config;
        $this->router = $router;

        /*
         * -------- DEFAULT CONFIGURATIONS --------
         */
        $this->config()->add('DEBUG', 'false'); // TODO:
        $this->config()->add('LOGGER', [
            'default_logger_name' => 'app',
            'loggers' => [
                'app' => [
                    'logger_factory' => '\Mvc4Wp\System\Logger\FileLoggerFactory',
                    'directory' => __MVC4WP_ROOT__ . '/log/',
                    'basefilename' => 'app',
                    'file_date_format' => 'Ymd',
                    'datetime_format' => 'Y-m-d H:i:s',
                    'timezone' => 'Asia/Tokyo',
                    'log_level' => 'notice',
                ],
                'system' => [
                    'logger_factory' => '\Mvc4Wp\System\Logger\FileLoggerFactory',
                    'directory' => __MVC4WP_ROOT__ . '/log/',
                    'basefilename' => 'sys',
                    'file_date_format' => 'Ymd',
                    'datetime_format' => 'Y-m-d H:i:s',
                    'timezone' => 'Asia/Tokyo',
                    'log_level' => 'notice',
                ],
            ],
        ]);
        $this->config()->add('CONTROLLER_NAMESPACE', 'App\Controller');
        $this->config()->add('VIEW_DIRECTORY', __MVC4WP_ROOT__ . '/src/App/View/');

        include_once(__MVC4WP_ROOT__ . '/src/System/Core/Common.php');
    }

    public function config(): ConfiguratorInterface
    {
        return $this->config;
    }

    public function router(): RouterInterface
    {
        return $this->router;
    }

    public function controller(): ControllerInterface
    {
        return $this->controller;
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
            $route = $this->router->dispatch($this->config, $request_method, $_SERVER['REQUEST_URI']);

            if ($route->status !== HttpStatus::OK) {
                $controller = new HttpErrorController($this->config, $route->status); // TODO: error controller define config
                $controller->index();
                return;
            }

            if (!class_exists($route->class)) {
                throw new ApplicationException();
            }

            $controller = new $route->class($this->config());
            $this->controller = $controller;
            if (!method_exists($controller, $route->method)) {
                throw new ApplicationException();
            }

            if (method_exists($controller, 'init')) {
                Logging::get('system')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '::init', $route->args);
                $controller->init($route->args);
            }

            Logging::get('system')->debug($_SERVER['REQUEST_URI'] . ' => ' . $route->class . '::' . $route->method, $route->args);
            $controller->{$route->method}($route->args);
        } catch (ApplicationException $ex) {
            Logging::get('system')->error($ex->getMessage(), [$ex]);
            $controller = new HttpErrorController($this->config, HttpStatus::INTERNAL_SERVER_ERROR); // TODO: error controller define config
            $controller->index();
            return;
        }
    }
}