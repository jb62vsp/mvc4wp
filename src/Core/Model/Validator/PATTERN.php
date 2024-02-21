<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validator;

enum PATTERN: string
{
    case NONE = 'NONE';
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