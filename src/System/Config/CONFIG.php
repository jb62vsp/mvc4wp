<?php declare(strict_types=1);
namespace Mvc4Wp\System\Config;

enum CONFIG: string
{
    case DEBUG = 'DEBUG';
    case LOGGER = 'LOGGER';
    case CONTROLLER_NAMESPACE = 'CONTROLLER_NAMESPACE';
    case VIEW_DIRECTORY = 'VIEW_DIRECTORY';
}