<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

use DateTimeZone;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Clock::class)]
final class ClockTest extends TestCase
{
    public function test_get_now(): void
    {
        $actual = Clock::get();
        $this->assertInstanceOf('DateTime', $actual);
    }

    public function test_get_format(): void
    {
        $actual = Clock::get('2024-01-01 12:34:56');
        $this->assertEquals('2024/01/01 12:34:56', $actual->format('Y/m/d H:i:s'));
    }

    public function test_get_withTimezone(): void
    {
        $actual = Clock::get('2024-01-01 12:34:56', new DateTimeZone('UTC'));
        $actual->setTimezone(new DateTimeZone('Asia/Tokyo'));
        $this->assertEquals('2024-01-01T21:34:56+09:00', $actual->format('c'));
    }

    public function test_get_withoutTimezone(): void
    {
        $actual = Clock::get('2024-01-01T12:34:56.123Z');
        $actual->setTimezone(new DateTimeZone('Asia/Tokyo'));
        $this->assertEquals('2024-01-01T21:34:56+09:00', $actual->format('c'));
    }
}