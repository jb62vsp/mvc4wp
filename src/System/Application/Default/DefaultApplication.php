<?php declare(strict_types=1);
namespace Mvc4Wp\System\Application\Default;

use Mvc4Wp\System\Application\AbstractApplication;
use Mvc4Wp\System\Config\ConfigInterface;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Route\RouterInterface;

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
        $this->config()->add(\Mvc4Wp\System\Config\CONFIG::DEBUG, 'false'); // TODO:
        $this->config()->add(\Mvc4Wp\System\Config\CONFIG::LOGGER, [
            'default_logger_name' => 'app',
            'loggers' => [
                'app' => [
                    'logger_factory' => '\Mvc4Wp\System\Logger\FileLoggerFactory',
                    'directory' => __WPMVC_ROOT__ . '/log/',
                    'basefilename' => 'app',
                    'file_date_format' => 'Ymd',
                    'datetime_format' => 'Y-m-d H:i:s',
                    'timezone' => 'Asia/Tokyo',
                    'log_level' => 'notice',
                ],
                'system' => [
                    'logger_factory' => '\Mvc4Wp\System\Logger\FileLoggerFactory',
                    'directory' => __WPMVC_ROOT__ . '/log/',
                    'basefilename' => 'sys',
                    'file_date_format' => 'Ymd',
                    'datetime_format' => 'Y-m-d H:i:s',
                    'timezone' => 'Asia/Tokyo',
                    'log_level' => 'notice',
                ],
            ],
        ]);
        $this->config()->add(\Mvc4Wp\System\Config\CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
        $this->config()->add(\Mvc4Wp\System\Config\CONFIG::VIEW_DIRECTORY, __WPMVC_ROOT__ . '/src/App/Views/');

        include_once(__WPMVC_ROOT__ . '/src/System/Core/Common.php');
    }

    public function run(): void
    {
        $this->executeController($this->config(), $this->router());
    }
}