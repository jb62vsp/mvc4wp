<?php declare(strict_types=1);
namespace System\Application\Default;

use System\Application\AbstractApplication;
use System\Config\ConfigInterface;
use System\Core\Cast;
use System\Route\RouterInterface;

class DefaultApplication extends AbstractApplication
{
    use Cast;

    public function __construct(
        ConfigInterface $config,
        RouterInterface $router,
    ) {
        $this->config = $config;
        $this->router = $router;

        /*
         * -------- DEFAULT CONFIGURATIONS --------
         */
        $this->config()->add(\System\Config\CONFIG::DEBUG, 'false'); // TODO:
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
        include_once(__WPMVC_ROOT__ . '/src/System/Core/Common.php');
    }

    public function run(): void
    {
        $this->executeController($this->config(), $this->router());
    }
}