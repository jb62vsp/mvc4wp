<?php declare(strict_types=1);
namespace System\Models;

enum PATTERN: string
{
    case BOOL = 'BOOL';
    case INTEGER = 'INTEGER';
    case UINTEGER = 'UINTEGER';
    case FLOAT = 'FLOAT';
    case UFLOAT = 'UFLOAT';
    case ALPHABET = 'ALPHABET';
    case ALPHANUM = 'ALPHANUM';
    case SYMBOL = 'SYMBOL';
    case HALFCHAR = 'HALFCHAR';
    case DATE = 'DATE';
    case TIME = 'TIME';
    case DATETIME = 'DATETIME';
}