<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

enum TypeInQuery: string
{
    case NUMERIC = 'NUMERIC';
    case BINARY = 'BINARY';
    case CHAR = 'CHAR';
    case DATE = 'DATE';
    case DATETIME = 'DATETIME';
    case DECIMAL = 'DECIMAL';
    case SIGNED = 'SIGNED';
    case TIME = 'TIME';
    case UNSIGNED = 'UNSIGNED';
}