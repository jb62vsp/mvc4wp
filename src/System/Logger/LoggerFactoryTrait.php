<?php declare(strict_types=1);
namespace Mvc4Wp\System\Logger;

use Psr\Log\LoggerInterface;

trait LoggerFactoryTrait
{
    abstract public function create(array $args = []): LoggerInterface;
}