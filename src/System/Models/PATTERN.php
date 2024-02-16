<?php declare(strict_types=1);
namespace System\Models;

enum PATTERN: string
{
    case BOOL = 'BOOL';
    case INTEGER = 'INTEGER';
    case FLOAT = 'FLOAT';
    case ALPHABET = 'ALPHABET';
    case ALPHANUM = 'ALPHANUM';
    case DATE = 'DATE';
    case TIME = 'TIME';
    case DATETIME = 'DATETIME';
}