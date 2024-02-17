<?php declare(strict_types=1);
namespace System\Logger;

use Psr\Log\LoggerInterface;
use System\Config\ConfigInterface;

trait LoggerFactoryTrait
{
    abstract public function create(string $logger_name, array $config): LoggerInterface;
}