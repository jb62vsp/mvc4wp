<?php declare(strict_types=1);
namespace System\Logger;

use Psr\Log\LoggerInterface;

trait LoggerFactoryTrait
{
    abstract public function create(string $logger_name, array $config): LoggerInterface;
}