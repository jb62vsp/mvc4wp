<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Default;

use Mvc4Wp\Core\Library\ClockFactoryInterface;
use Mvc4Wp\Core\Library\ClockInterface;

class DefaultClockFactory implements ClockFactoryInterface
{
    public static function create(array $args = []): ClockInterface
    {
        return new DefaultClock();
    }
}