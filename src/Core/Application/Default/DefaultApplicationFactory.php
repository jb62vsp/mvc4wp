<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application\Default;

use Mvc4Wp\Core\Application\ApplicationFactoryInterface;
use Mvc4Wp\Core\Application\ApplicationInterface;
use Mvc4Wp\Core\Config\Default\DefaultConfiguratorFactory;
use Mvc4Wp\Core\Controller\Default\DefaultErrorController;
use Mvc4Wp\Core\Library\Default\DefaultClockFactory;
use Mvc4Wp\Core\Logger\Default\DefaultFileLoggerFactory;
use Mvc4Wp\Core\Route\Default\DefaultRouterFactory;

class DefaultApplicationFactory implements ApplicationFactoryInterface
{
    public function create(array $args = []): ApplicationInterface
    {
        $config = (new DefaultConfiguratorFactory())->create();
        /*
         * -------- DEFAULT CONFIGURATIONS --------
         */
        $config->add('DEBUG', 'false'); // TODO:
        $config->add('CORE_ROOT', __MVC4WP_ROOT__ . '/src/Core');
        $config->add('APP_ROOT', __MVC4WP_ROOT__ . '/src/App');
        $config->add('CONTROLLER_NAMESPACE', 'App\Controller');
        $config->add('VIEW_DIRECTORY', __MVC4WP_ROOT__ . '/src/App/View');
        $config->add('ERROR_HANDLERS', [
            'default_handler_name' => 'default',
            'handlers' => [
                'default' => DefaultErrorController::class,
            ],
        ]);
        $config->add('FACTORY', [
            'clock' => DefaultClockFactory::class,
            'router' => DefaultRouterFactory::class,
        ]);
        $config->add('LOGGER', [
            'default_logger_name' => 'app',
            'loggers' => [
                'app' => [
                    'logger_factory' => DefaultFileLoggerFactory::class,
                    'directory' => __MVC4WP_ROOT__ . '/log/',
                    'basefilename' => 'app',
                    'file_date_format' => 'Ymd',
                    'datetime_format' => 'Y-m-d H:i:s',
                    'timezone' => 'Asia/Tokyo',
                    'log_level' => 'notice',
                ],
                'core' => [
                    'logger_factory' => DefaultFileLoggerFactory::class,
                    'directory' => __MVC4WP_ROOT__ . '/log/',
                    'basefilename' => 'core',
                    'file_date_format' => 'Ymd',
                    'datetime_format' => 'Y-m-d H:i:s',
                    'timezone' => 'Asia/Tokyo',
                    'log_level' => 'notice',
                ],
            ],
        ]);

        return new DefaultApplication($config);
    }
}