<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application\Default;

use Mvc4Wp\Core\Application\ApplicationFactoryInterface;
use Mvc4Wp\Core\Application\ApplicationInterface;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
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
        if (array_key_exists('config', $args) && $args['config'] instanceof ConfiguratorInterface) {
            $config = $args['config'];
        } else {
            /*
             * -------- DEFAULT CONFIGURATIONS --------
             */
            $config->add('debug', 'false'); // TODO:
            $config->add('core_root', __MVC4WP_ROOT__ . '/src/Core');
            $config->add('app_root', __MVC4WP_ROOT__ . '/src/App');
            $config->add('controller_namespace', 'App\Controller');
            $config->add('view_directory', __MVC4WP_ROOT__ . '/src/App/View');
            $config->add('error_handlers', [
                'default_handler_name' => 'default',
                'handlers' => [
                    'default' => DefaultErrorController::class,
                ],
            ]);
            $config->add('factory', [
                'clock' => DefaultClockFactory::class,
                'router' => DefaultRouterFactory::class,
            ]);
            $config->add('logger', [
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
                ],
            ]);
        }
        if (is_null($config->get('logger.loggers.core'))) {
            $config->set('logger.loggers.core', [
                'logger_factory' => DefaultFileLoggerFactory::class,
                'directory' => __MVC4WP_ROOT__ . '/log/',
                'basefilename' => 'core',
                'file_date_format' => 'Ymd',
                'datetime_format' => 'Y-m-d H:i:s',
                'timezone' => 'Asia/Tokyo',
                'log_level' => 'notice',

            ]);
        }

        return new DefaultApplication($config);
    }
}