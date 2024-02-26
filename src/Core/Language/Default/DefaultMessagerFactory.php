<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Language\Default;

use Mvc4Wp\Core\Config\ConfiguratorInterface;
use Mvc4Wp\Core\Exception\ApplicationException;
use Mvc4Wp\Core\Language\LanguageUtils;
use Mvc4Wp\Core\Language\MessagerFactoryInterface;
use Mvc4Wp\Core\Language\MessagerInterface;

class DefaultMessagerFactory implements MessagerFactoryInterface
{
    public static function create(array $args = []): MessagerInterface
    {
        if (!array_key_exists('config', $args) || !is_object($args['config']) || !($args['config'] instanceof ConfiguratorInterface)) {
            throw new ApplicationException('language'); // TODO
        }

        /** @var ConfiguratorInterface $config */
        $config = $args['config'];
        $fallback_locale = $config->get('language.fallback_locale') ?: 'en_US';
        $message_directory = $config->get('language.message_directory') ?: '/Language';
        $message_filename = $config->get('language.message_filename') ?: 'Messages.php';

        $app_root = $config->get('app_root');
        $core_root = $config->get('core_root');

        $locale_string = LanguageUtils::getLocale();
        if (empty($locale_string)) {
            $locale_string = $fallback_locale;
        }

        $app_messages_path = $app_root . $message_directory . DIRECTORY_SEPARATOR . $locale_string . DIRECTORY_SEPARATOR . $message_filename;
        $core_messages_path = $core_root . $message_directory . DIRECTORY_SEPARATOR . $locale_string . DIRECTORY_SEPARATOR . $message_filename;

        return new DefaultMessager($locale_string, $app_messages_path, $core_messages_path);
    }
}