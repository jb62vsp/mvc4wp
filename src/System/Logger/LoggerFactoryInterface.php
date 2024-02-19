<?php declare(strict_types=1);
namespace Wp4Mvc\System\Logger;

use Psr\Log\LoggerInterface;

interface LoggerFactoryInterface
{
    public function create(array $args = []): LoggerInterface;
}