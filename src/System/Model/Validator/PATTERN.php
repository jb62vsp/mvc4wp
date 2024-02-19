<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model\Validator;

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