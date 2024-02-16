<?php declare(strict_types=1);
namespace System\Route;

use System\Core\Cast;
use System\Core\HttpStatus;

final class RouteHandler
{
    use Cast;

    public function __construct(
        public HttpStatus $status,
        public string $signature = '',
        public array $args = [],
    ) {

    }
}