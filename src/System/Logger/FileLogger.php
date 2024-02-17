<?php declare(strict_types=1);
namespace System\Logger;

use Psr\Log\AbstractLogger;
use System\Config\CONFIG;
use System\Config\ConfigInterface;
use System\Helper\DateTimeHelper;

class FileLogger extends AbstractLogger
{
    protected string $directory;

    protected string $filename;

    protected string $date_format;

    public function __construct(ConfigInterface $config)
    {
        $this->directory = $config->get(CONFIG::LOG_DIRECTORY);
        $this->filename = $config->get(CONFIG::LOG_FILENAME);
        $this->date_format = $config->get(CONFIG::LOG_DATE_FORMAT);
    }

    protected function getFilePath(): string
    {
        $date = DateTimeHelper::now($this->date_format);
        $path = $this->directory . $this->filename . '.' . $date . '.log';
        return $path;
    }

    protected function out(string $line): void
    {
        $create = false;

        if (!file_exists($this->getFilePath())) {
            $create = true;
        }

        if (!$fp = @fopen($this->getFilePath(), 'ab')) {
            return;
        }

        flock($fp, LOCK_EX);
        $result = null;
        for ($i = 0, $il = strlen($line); $i < $il; $i += $result) {
            if (($result = fwrite($fp, substr($line, $i))) === false) {
                break;
            }
        }
        flock($fp, LOCK_UN);
        fclose($fp);

        if ($create) {
            chmod($this->getFilePath(), 0666);
        }
    }

    public function log($level, string|\Stringable $message, array $context = []): void
    {
        $date = DateTimeHelper::datetime();
        $this->out(strtoupper($level) . ' - ' . $date . ' --> ' . $message . "\n");
    }
}
