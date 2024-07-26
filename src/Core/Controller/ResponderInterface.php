<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\HttpStatus;

interface ResponderInterface
{
    public function responder(): static;
    public function done(): never;
    public function ok(): static;
    public function seeOther(string $url): static;
    public function forbidden(): static;
    public function notFound(): static;
    public function header(string $message): static;
    public function response(HttpStatus $status_code = HttpStatus::OK, bool $replace = true, string $addition = ""): static;
}