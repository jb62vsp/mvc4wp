<?php declare(strict_types=1);
namespace System\Config;


enum CONFIG: string
{
    case DEBUG = 'DEBUG';
    case MODEL_NAMESPACE = 'MODEL_NAMESPACE';
    case CONTROLLER_NAMESPACE = 'CONTROLLER_NAMESPACE';
    case VIEW_DIRECTORY = 'VIEW_DIRECTORY';
    case PUBLIC_DIRECTORY = 'PUBLIC_DIRECTORY';
}