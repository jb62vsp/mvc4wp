<?php declare(strict_types=1);
namespace System\Route;

use System\Core\Cast;
use System\Core\HttpStatus;
use System\Exception\ApplicationException;

final class RouteHandler
{
    use Cast;

    private const DELIMITER = '::';

    public string $class = '';

    public string $method = '';

    public function __construct(
        public HttpStatus $status,
        public string $signature = '',
        public array $args = [],
    ) {
        if (!empty($signature)) {
            $signatures = explode(self::DELIMITER, $signature);
            if (count($signatures) !== 2) {
                throw new ApplicationException();
            }
            $this->class = $signatures[0];
            $this->method = $signatures[1];
        }
    }
}