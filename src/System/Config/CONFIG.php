<?php declare(strict_types=1);
namespace System\Config;

enum CONFIG: string
{
    case DEBUG = 'DEBUG';
    case LOGGER = 'LOGGER';
    case LOG_DIRECTORY = 'LOG_DIRECTORY';
    case LOG_FILENAME = 'LOG_FILENAME';
    case LOG_DATE_FORMAT = 'LOG_DATE_FORMAT';
    case CONTROLLER_NAMESPACE = 'CONTROLLER_NAMESPACE';
    case VIEW_DIRECTORY = 'VIEW_DIRECTORY';
}