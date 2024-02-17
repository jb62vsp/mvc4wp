<?php declare(strict_types=1);
namespace System\Logger;

abstract class AbstractLoggerFactory implements LoggerFactoryInterface
{
    use LoggerFactoryTrait;
}