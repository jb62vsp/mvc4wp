<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Validation;

enum CommonPattern: string
{
    case BOOL = '/^$|^([01])$/';
    case INTEGER = '/^$|^(-{0,1})([0-9]+)$/';
    case UINTEGER = '/^$|^([0-9]+)$/';
    case FLOAT = '/^$|^(-{0,1}[0-9]+\.{0,1}[0-9]*)$/';
    case UFLOAT = '/^$|^([0-9]+\.{0,1}[0-9]*)$/';
    case ALPHABET = '/^$|^([a-zA-Z]+)$/';
    case ALPHANUM = '/^$|^([a-zA-Z0-9\.]+)$/';
    // case SYMBOL = '/^$|^([ -\/:-@[-`{-~]+)$/';
    // case HALFCHAR = '/^$|^([ -~]+)$/';
    case DATE = '/^$|^([1-9][0-9]{0,3})-([1-9]|0[1-9]|1[0-2])-([1-9]|0[1-9]|[12][0-9]|3[01])$/';
    case TIME = '/^$|^([0-9]|0[0-9]|1[0-9]|2[0-3]):([0-9]|0[0-9]|[1-5][0-9]):([0-9]|0[0-9]|[1-5][0-9])$/';
    case DATETIME = '/^$|^([1-9][0-9]{0,3})-([1-9]|0[1-9]|1[0-2])-([1-9]|0[1-9]|[12][0-9]|3[01]) ([0-9]|0[0-9]|1[0-9]|2[0-3]):([0-9]|0[0-9]|[1-5][0-9]):([0-9]|0[0-9]|[1-5][0-9])$/';

}