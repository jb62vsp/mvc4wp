<?php declare(strict_types=1);
namespace Wp4Mvc\System\Response;

use Wp4Mvc\System\Core\HttpStatus;

interface ResponderInterface
{
    public function responder(): self;
    public function done(): never;
    public function ok(): self;
    public function seeOther(string $url): self;
    public function forbidden(): self;
    public function notFound(): self;
    public function header(string $message): self;
    public function response(HttpStatus $status_code = HttpStatus::OK, bool $replace = true, string $addition = ""): self;
}