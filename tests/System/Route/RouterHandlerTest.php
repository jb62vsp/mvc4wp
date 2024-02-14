<?php declare(strict_types=1);
namespace System\Route;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use System\Core\HttpStatus;

#[CoversClass(RouteHandler::class)]
class RouterHandlerTest extends TestCase
{
    public function test_construct(): void
    {
        $obj = new RouteHandler(HttpStatus::OK, 'TestController::index', ['id' => 1]);

        $this->assertNotNull($obj);
        $this->assertEquals(200, $obj->status->value);
        $this->assertEquals('TestController::index', $obj->signature);
        $this->assertCount(1, $obj->args);
        $this->assertArrayHasKey('id', $obj->args);
        $this->assertEquals(1, $obj->args['id']);
    }
}
