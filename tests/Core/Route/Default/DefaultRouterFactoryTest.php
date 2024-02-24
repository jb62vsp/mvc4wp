<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Route\Default;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefaultRouterFactory::class)]
class DefaultRouterFactoryTest extends TestCase
{
    public function test_create(): void
    {
        $actual = DefaultRouterFactory::create();
        $this->assertInstanceOf(DefaultRouter::class, $actual);
    }
}