<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Default;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(DefaultClockFactory::class)]
class DefaultClockFactoryTest extends TestCase
{
    public function test_create(): void
    {
        $actual = DefaultClockFactory::create();
        $this->assertInstanceOf(DefaultClock::class, $actual);
    }
}