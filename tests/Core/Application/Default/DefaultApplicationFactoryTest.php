<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Application\Default;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Controller\Default\DefaultErrorController;
use Mvc4Wp\Core\Language\Default\DefaultMessagerFactory;
use Mvc4Wp\Core\Library\Default\DefaultClockFactory;
use Mvc4Wp\Core\Logger\NullLoggerFactory;
use Mvc4Wp\Core\Route\Default\DefaultRouterFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefaultApplicationFactory::class)]
class DefaultApplicationFactoryTest extends TestCase
{
    protected function setUp(): void
    {
        if (!defined('__MVC4WP_ROOT__')) {
            define('__MVC4WP_ROOT__', '/test');
        }
    }

    public function test_create(): void
    {
        $actual = DefaultApplicationFactory::create();
        $this->assertInstanceOf(DefaultApplication::class, $actual);
    }

    public function test_defaultConfig(): void
    {
        $actual = DefaultApplicationFactory::create();
        $this->assertIsArray($actual->config()->getAll());
        $this->assertEquals([
            'css' => [
                'css_directory' => '/test/css',
                'sass_directory' => '/test/sass',
                'scss_directory' => '/test/scss',
                'sass_path' => '/usr/local/bin/sass',
                'sass_args' => '',
                'use_cache' => 'true',
                'use_minify' => 'true',
            ],
            'error_handler' => [
                'default_handler_name' => 'default',
                'handlers' => [
                    'default' => DefaultErrorController::class,
                ],
            ],
            'factory' => [
                'clock' => DefaultClockFactory::class,
                'messager' => DefaultMessagerFactory::class,
                'router' => DefaultRouterFactory::class,
            ],
            'language' => [
                'fallback_locale' => 'en_US',
                'message_directory' => '/Language/Messages',
            ],
            'logger' =>
                [
                    'default_logger_name' => 'app',
                    'loggers' => [
                        'app' => [
                            'logger_factory' => NullLoggerFactory::class,
                            'directory' => '/test/log/',
                            'basefilename' => 'app',
                            'file_date_format' => 'Ymd',
                            'datetime_format' => 'Y-m-d H:i:s',
                            'timezone' => 'Asia/Tokyo',
                            'log_level' => 'info',
                        ],
                        'core' => [
                            'logger_factory' => NullLoggerFactory::class,
                            'directory' => '/test/log/',
                            'basefilename' => 'core',
                            'file_date_format' => 'Ymd',
                            'datetime_format' => 'Y-m-d H:i:s',
                            'timezone' => 'Asia/Tokyo',
                            'log_level' => 'notice',
                        ],
                    ],
                ],
            'js' => [
                'js_directory' => '/test/js',
                'use_minify' => 'true',
            ],
            'app_root' => '/test/src/App',
            'core_root' => '/test/src/Core',
            'view_directory' => '/test/src/App/View',
        ], $actual->config()->getAll());
    }

    public function test_createWithConfig(): void
    {
        $stub = $this->createStub(ConfiguratorInterface::class);
        $stub->method('get')->willReturn('hoge');
        $actual = DefaultApplicationFactory::create(['config' => $stub]);
        $this->assertInstanceOf(DefaultApplication::class, $actual);
    }

    public function test_createWithoutConfig(): void
    {
        $stub = $this->createStub(ConfiguratorInterface::class);
        $stub->method('get')->willReturn('hoge');
        $actual = DefaultApplicationFactory::create(['configure' => $stub]);
        $this->assertInstanceOf(DefaultApplication::class, $actual);
    }

    public function test_createWithInvalidConfig(): void
    {
        $actual = DefaultApplicationFactory::create(['config' => ['hoge' => 'fuga']]);
        $this->assertInstanceOf(DefaultApplication::class, $actual);
    }
}
