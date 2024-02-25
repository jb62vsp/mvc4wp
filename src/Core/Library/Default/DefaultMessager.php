<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Default;

use MessageFormatter;
use Mvc4Wp\Core\Library\MessagerInterface;
use Stringable;

class DefaultMessager implements MessagerInterface
{
    protected string $locale_string = ''; // TODO:

    public function format(string|Stringable $message, array $args = []): string|false
    {
        $result = match ($message instanceof Stringable) {
            true => MessageFormatter::formatMessage($this->locale_string, $message->__toString(), $args),
            false => MessageFormatter::formatMessage($this->locale_string, $message, $args),
        };

        return $result;
    }
}