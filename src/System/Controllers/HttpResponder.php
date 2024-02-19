<?php declare(strict_types=1);
namespace Mvc4Wp\System\Controllers;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Core\HttpStatus;

trait HttpResponder
{
    use Cast;

    /*
     * --------------------------------------------------------------------
     * HTTP response section
     * --------------------------------------------------------------------
     */

    private const STATUSES = [
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        103 => 'Early Hints',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => 'Switch Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Content Too Large',
        414 => 'URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => "I'm a teapot",
        421 => 'Misdirected Request',
        422 => 'Unprocessable Content',
        423 => 'Locked',
        424 => 'Failed Dependency',
        425 => 'Too Early',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        451 => 'Unavailable For Legal Reasons',
        499 => 'Client Closed Request',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        599 => 'Network Connect Timeout Error',
    ];

    public function responder(): self
    {
        return $this;
    }

    public function done(): never
    {
        exit();
    }

    public function ok(): self
    {
        return $this->Response(HttpStatus::OK);
    }

    public function seeOther(string $url): self
    {
        return $this->Response(HttpStatus::SEE_OTHER, replace: false, addition: 'Location: ' . $url);
    }

    public function forbidden(): self
    {
        return $this->Response(HttpStatus::FORBIDDEN);
    }

    public function notFound(): self
    {
        return $this->Response(HttpStatus::NOT_FOUND);
    }

    public function header(string $message): self
    {
        header($message, false);
        return $this;
    }

    public function response(HttpStatus $status_code = HttpStatus::OK, bool $replace = true, string $addition = ""): self
    {
        header($this->createResponse($status_code), $replace, $status_code->value);
        if (!empty($addition)) {
            $this->header($addition);
        }
        return $this;
    }

    private function createResponse(HttpStatus $status_code = HttpStatus::OK): string
    {
        return 'HTTP/1.1 ' . $status_code->value . ' ' . self::STATUSES[$status_code->value];
    }
}