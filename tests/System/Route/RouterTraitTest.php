<?php declare(strict_types=1);
namespace System\Route;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Config\Configrator;

#[CoversClass(Configrator::class)]
#[CoversClass(RouteHandler::class)]
#[CoversClass(DefaultRouter::class)]
class RouterTraitTest extends TestCase
{
    private function getRouter(): RouterInterface
    {
        return new RouterMock();
    }

    private function getConfig(): ConfigInterface
    {
        return new ConfigMock();
    }

    public function test_router(): void
    {
        $router = $this->getRouter();

        $router2 = $router->router();
        $this->assertNotNull($router);
        $this->assertEquals($router, $router2);
    }

    public function test_getOkCase01(): void
    {
        $router = $this->getRouter();
        $router->get('/', 'HomeController::index');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'GET', '/');

        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::index', $handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_getOkCase02(): void
    {
        $router = $this->getRouter();
        $router->get('/', 'HomeController::index');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'get', '/');

        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::index', $handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_getOkCase03(): void
    {
        $router = $this->getRouter();
        $router->get('/home/index', 'HomeController::index');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'GET', '/home/index');

        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::index', $handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_getOkCase04(): void
    {
        $router = $this->getRouter();
        $router->get('/home/{id:\d+}', 'HomeController::index');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'GET', '/home/123');

        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::index', $handler->signature);
        $this->assertEquals(1, count($handler->args));
        $this->assertArrayHasKey('id', $handler->args);
        $this->assertEquals(123, $handler->args['id']);
    }

    public function test_getOkCase05(): void
    {
        $router = $this->getRouter();
        $router->get('/home/{name}', 'HomeController::index');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'GET', '/home/abc');

        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::index', $handler->signature);
        $this->assertEquals(1, count($handler->args));
        $this->assertArrayHasKey('name', $handler->args);
        $this->assertEquals('abc', $handler->args['name']);
    }

    public function test_getOkCase06(): void
    {
        $router = $this->getRouter();
        $router->get('/home/{name}/{id:\d+}', 'HomeController::index');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'GET', '/home/abc/123');

        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::index', $handler->signature);
        $this->assertEquals(2, count($handler->args));
        $this->assertArrayHasKey('name', $handler->args);
        $this->assertEquals('abc', $handler->args['name']);
        $this->assertArrayHasKey('id', $handler->args);
        $this->assertEquals(123, $handler->args['id']);
    }

    public function test_getNgCase01(): void
    {
        $router = $this->getRouter();
        $router->get('/', 'HomeController::index');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'GET', '/nothing');

        $this->assertNotNull($handler);
        $this->assertEquals(404, $handler->status->value);
        $this->assertEmpty($handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_getNgCase02(): void
    {
        $router = $this->getRouter();
        $router->get('/', 'HomeController::index');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'HOGE', '/');

        $this->assertNotNull($handler);
        $this->assertEquals(405, $handler->status->value);
        $this->assertEmpty($handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_postOkCase01(): void
    {
        $router = $this->getRouter();
        $router->post('/', 'HomeController::register');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'POST', '/');
 
        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::register', $handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_postOkCase02(): void
    {
        $router = $this->getRouter();
        $router->post('/', 'HomeController::register');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'post', '/');
 
        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::register', $handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_putOkCase01(): void
    {
        $router = $this->getRouter();
        $router->put('/', 'HomeController::update');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'PUT', '/');
 
        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::update', $handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_putOkCase02(): void
    {
        $router = $this->getRouter();
        $router->put('/', 'HomeController::update');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'put', '/');
 
        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::update', $handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_deleteOkCase01(): void
    {
        $router = $this->getRouter();
        $router->delete('/', 'HomeController::delete');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'DELETE', '/');
 
        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::delete', $handler->signature);
        $this->assertEquals(0, count($handler->args));
    }

    public function test_deleteOkCase02(): void
    {
        $router = $this->getRouter();
        $router->delete('/', 'HomeController::delete');
        $config = $this->getConfig();
        $handler = $router->dispatch($config, 'delete', '/');
 
        $this->assertNotNull($handler);
        $this->assertEquals(200, $handler->status->value);
        $this->assertEquals('App\Controllers\HomeController::delete', $handler->signature);
        $this->assertEquals(0, count($handler->args));
    }
}

class RouterMock implements RouterInterface
{
    use DefaultRouter;
}

class ConfigMock implements ConfigInterface
{
    use Configrator;

    public function __construct()
    {
        $this->addConfig(CONFIG::CONTROLLER_NAMESPACE, 'App\Controllers');
    }
}