<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Library;

class LanguageUtils
{
    public static function getLocale(): string
    {
        return get_locale();
    }
}