<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Controller;

use Mvc4Wp\Core\Library\HttpStatus;
use Mvc4Wp\Core\Service\App;

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
        return $this->errorResponse(HttpStatus::FORBIDDEN);
    }

    public function notFound(): static
    {
        return $this->errorResponse(HttpStatus::NOT_FOUND);
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

    public function errorResponse(HttpStatus $status_code, bool $replace = true, string $addition = ""): static
    {
        $this->Response($status_code);
        App::get()->errorHandler($status_code)->init([$status_code]);
        App::get()->errorHandler($status_code)->index([$status_code]);
        return $this;
    }

    private function createResponse(HttpStatus $status_code = HttpStatus::OK): string
    {
        return 'HTTP/1.1 ' . $status_code->value . ' ' . HttpStatusMap::STATUSES[$status_code->value];
    }
}