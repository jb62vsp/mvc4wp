<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application\Default;

use Mvc4Wp\Core\Application\ApplicationFactoryInterface;
use Mvc4Wp\Core\Application\ApplicationInterface;
use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Config\Default\DefaultConfiguratorFactory;
use Mvc4Wp\Core\Controller\Default\DefaultErrorController;
use Mvc4Wp\Core\Language\Default\DefaultMessagerFactory;
use Mvc4Wp\Core\Library\Default\DefaultClockFactory;
use Mvc4Wp\Core\Logger\Default\DefaultFileLoggerFactory;
use Mvc4Wp\Core\Route\Default\DefaultRouterFactory;

class DefaultApplicationFactory implements ApplicationFactoryInterface
{
    public static function create(array $args = []): ApplicationInterface
    {
        $config = self::initConfig($args);

        $config = self::setErrorHandler($config);
        $config = self::setFactory($config);
        $config = self::setLanguage($config);
        $config = self::setLogger($config);
        $config = self::setJs($config);
        $config = self::setNamespace($config);
        $config = self::setRoot($config);
        $config = self::setScss($config);


        return new DefaultApplication($config);
    }

    private static function initConfig(array $args): ConfiguratorInterface
    {
        $config = DefaultConfiguratorFactory::create();

        if (array_key_exists('config', $args) && $args['config'] instanceof ConfiguratorInterface) {
            $config = $args['config'];
        }

        return $config;
    }

    private static function setErrorHandler(ConfiguratorInterface $config): ConfiguratorInterface
    {
        if (is_null($config->get('error_handler'))) {
            $config->add('error_handler', [
                'default_handler_name' => 'default',
                'handlers' => [
                    'default' => DefaultErrorController::class,
                ],
            ]);
        }

        return $config;
    }

    private static function setFactory(ConfiguratorInterface $config): ConfiguratorInterface
    {
        if (is_null($config->get('factory'))) {
            $config->add('factory', [
                'clock' => DefaultClockFactory::class,
                'messager' => DefaultMessagerFactory::class,
                'router' => DefaultRouterFactory::class,
            ]);
        }

        return $config;
    }

    private static function setLanguage(ConfiguratorInterface $config): ConfiguratorInterface
    {
        if (is_null($config->get('language'))) {
            $config->add('language', [
                'fallback_locale' => 'en_US',
                'message_directory' => '/Language',
                'message_filename' => 'Messages.php',
            ]);
        }

        return $config;
    }

    private static function setLogger(ConfiguratorInterface $config): ConfiguratorInterface
    {
        if (is_null($config->get('logger'))) {
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
                        'log_level' => 'info',
                    ],
                    'core' => [
                        'logger_factory' => DefaultFileLoggerFactory::class,
                        'directory' => __MVC4WP_ROOT__ . '/log/',
                        'basefilename' => 'core',
                        'file_date_format' => 'Ymd',
                        'datetime_format' => 'Y-m-d H:i:s',
                        'timezone' => 'Asia/Tokyo',
                        'log_level' => 'notice',
                    ]
                ],
            ]);
        }

        return $config;
    }

    private static function setJs(ConfiguratorInterface $config): ConfiguratorInterface
    {
        if (is_null($config->get('js'))) {
            $config->add('js', [
                'js_directory' => __MVC4WP_ROOT__ . '/js',
                'min_directory' => __MVC4WP_ROOT__ . '/js',
                'use_minify' => 'true',
            ]);
        }

        return $config;
    }

    private static function setNamespace(ConfiguratorInterface $config): ConfiguratorInterface
    {
        if (is_null($config->get('controller_namespace'))) {
            $config->add('controller_namespace', 'App\Controller');
        }

        return $config;
    }

    private static function setRoot(ConfiguratorInterface $config): ConfiguratorInterface
    {
        if (is_null($config->get('app_root'))) {
            $config->add('app_root', __MVC4WP_ROOT__ . '/src/App');
        }

        if (is_null($config->get('core_root'))) {
            $config->add('core_root', __MVC4WP_ROOT__ . '/src/Core');
        }

        if (is_null($config->get('view_directory'))) {
            $config->add('view_directory', __MVC4WP_ROOT__ . '/src/App/View');
        }

        return $config;
    }

    private static function setScss(ConfiguratorInterface $config): ConfiguratorInterface
    {
        if (is_null($config->get('scss'))) {
            $config->add('scss', [
                'scss_directory' => __MVC4WP_ROOT__ . '/css',
                'css_directory' => __MVC4WP_ROOT__ . '/css',
                'use_cache' => 'true',
            ]);
        }

        return $config;
    }
}