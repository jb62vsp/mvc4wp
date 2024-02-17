<?php declare(strict_types=1);
namespace System\Logger;

use Psr\Log\LoggerInterface;

interface LoggerFactoryInterface
{
    public function create(string $logger, array $config): LoggerInterface;
}