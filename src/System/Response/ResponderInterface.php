<?php declare(strict_types=1);
namespace System\Response;

use System\Core\HttpStatus;

interface ResponderInterface
{
    public function done(): never;
    public function ok(): self;
    public function seeOther(string $url): self;
    public function forbidden(): self;
    public function notFound(): self;
    public function response(HttpStatus $status_code = HttpStatus::OK, bool $replace = true, string $addition = ""): self;
}