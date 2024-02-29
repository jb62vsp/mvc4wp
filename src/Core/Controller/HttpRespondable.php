<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\HttpStatus;

trait HttpRespondable
{
    public function responder(): static
    {
        return $this;
    }

    public function done(): never
    {
        debug_view();
        exit();
    }

    public function ok(): static
    {
        return $this->Response(HttpStatus::OK);
    }

    public function seeOther(string $url): static
    {
        return $this->Response(HttpStatus::SEE_OTHER, replace: false, addition: 'Location: ' . $url);
    }

    public function forbidden(): static
    {
        return $this->Response(HttpStatus::FORBIDDEN);
    }

    public function notFound(): static
    {
        return $this->Response(HttpStatus::NOT_FOUND);
    }

    public function header(string $message): static
    {
        header($message, false);
        return $this;
    }

    public function response(HttpStatus $status_code = HttpStatus::OK, bool $replace = true, string $addition = ""): static
    {
        header($this->createResponse($status_code), $replace, $status_code->value);
        if (!empty($addition)) {
            $this->header($addition);
        }
        return $this;
    }

    private function createResponse(HttpStatus $status_code = HttpStatus::OK): string
    {
        return 'HTTP/1.1 ' . $status_code->value . ' ' . HttpStatusMap::STATUSES[$status_code->value];
    }
}