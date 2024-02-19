<?php declare(strict_types=1);
namespace Wp4Mvc\System\Logger;

use Psr\Log\LoggerInterface;

trait LoggerFactoryTrait
{
    abstract public function create(array $args = []): LoggerInterface;
}