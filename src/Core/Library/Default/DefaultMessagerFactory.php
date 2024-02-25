<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library\Default;

use Mvc4Wp\Core\Library\LanguageUtils;
use Mvc4Wp\Core\Library\MessagerFactoryInterface;
use Mvc4Wp\Core\Library\MessagerInterface;

class DefaultMessagerFactory implements MessagerFactoryInterface
{
    public static function create(array $args = []): MessagerInterface
    {
        $locale_string = LanguageUtils::getLocale();

        return new DefaultMessager($locale_string);
    }
}