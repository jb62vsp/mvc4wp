<?php declare(strict_types=1);
namespace Wp4Mvc\System\Application\Default;

use Wp4Mvc\System\Application\AbstractApplication;
use Wp4Mvc\System\Config\ConfigInterface;
use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Route\RouterInterface;

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
        $this->config()->add(\Wp4Mvc\System\Config\CONFIG::DEBUG, 'false'); // TODO:
        $this->config()->add(\Wp4Mvc\System\Config\CONFIG::LOGGER, [
            'default_logger_name' => 'app',
            'loggers' => [
                'app' => [
                    'logger_factory' => '\Wp4Mvc\System\Logger\FileLoggerFactory',
                    'directory' => __WPMVC_ROOT__ . '/log/',
                    'basefilename' => 'app',
                    'file_date_format' => 'Ymd',
                    'datetime_format' => 'Y-m-d H:i:s',
                    'timezone' => 'Asia/Tokyo',
                    'log_level' => 'notice',
                ],
                'system' => [
                    'logger_factory' => '\Wp4Mvc\System\Logger\FileLoggerFactory',
                    'directory' => __WPMVC_ROOT__ . '/log/',
                    'basefilename' => 'sys',
                    'file_date_format' => 'Ymd',
                    'datetime_format' => 'Y-m-d H:i:s',
                    'timezone' => 'Asia/Tokyo',
                    'log_level' => 'notice',
                ],
            ],
        ]);
        $this->config()->add(\Wp4Mvc\System\Config\CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
        $this->config()->add(\Wp4Mvc\System\Config\CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');

        include_once(__WPMVC_ROOT__ . '/src/System/Core/Common.php');
    }

    public function run(): void
    {
        $this->executeController($this->config(), $this->router());
    }
}