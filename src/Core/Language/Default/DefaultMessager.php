<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Language\Default;

use MessageFormatter;
use Mvc4Wp\Core\Language\MessagerInterface;
use Mvc4Wp\Core\Library\RetrieveArray;

class DefaultMessager implements MessagerInterface
{
    public function __construct(
        protected string $locale_string,
        protected string $app_messages_path,
        protected string $core_messages_path,
    ) {
    }

    public function message(string $message_key, array $args = []): string
    {
        $message = $this->get_message($this->app_messages_path, $message_key);
        if (!$message) {
            $message = $this->get_message($this->core_messages_path, $message_key);
        }
        if (!$message) {
            return '';
        }

        $result = MessageFormatter::formatMessage($this->locale_string, $message, $args);

        return $result;
    }

    protected function get_message(string $filepath, string $message_key): string|false
    {
        if (!file_exists($filepath)) {
            return false;
        }

        include($filepath);
        if (!isset($messages)) {
            return false;
        }

        $message_keys = explode('.', $message_key);
        if (empty($message_keys) || $message_keys[0] === '') {
            return false;
        }

        $message = RetrieveArray::get($messages, $message_keys);
        if (is_null($message)) {
            return false;
        }

        return $message;
    }
}