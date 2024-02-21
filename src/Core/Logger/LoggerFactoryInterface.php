<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Logger;

use Psr\Log\LoggerInterface;

interface LoggerFactoryInterface
{
    public function create(array $args = []): LoggerInterface;
}