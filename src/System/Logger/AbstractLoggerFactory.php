<?php declare(strict_types=1);
namespace Wp4Mvc\System\Logger;

abstract class AbstractLoggerFactory implements LoggerFactoryInterface
{
    use LoggerFactoryTrait;
}