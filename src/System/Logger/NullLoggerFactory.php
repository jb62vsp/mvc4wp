<?php declare(strict_types=1);
namespace System\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use System\Logger\AbstractLoggerFactory;

class NullLoggerFactory extends AbstractLoggerFactory
{
    public function create(array $args = []): LoggerInterface
    {
        return new NullLogger();
    }
}