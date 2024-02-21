<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Logger;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Mvc4Wp\Core\Logger\AbstractLoggerFactory;

class NullLoggerFactory extends AbstractLoggerFactory
{
    public function create(array $args = []): LoggerInterface
    {
        return new NullLogger();
    }
}