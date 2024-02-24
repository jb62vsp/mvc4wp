<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

enum CompareInQuery: string
{
    case EQ = '=';
    case NOT = '!=';
    case GT = '>';
    case GE = '>=';
    case LT = '<';
    case LE = '<=';
    case LIKE = 'LIKE';
    case NOT_LIKE = 'NOT LIKE';
    case IN = 'IN';
    case NOT_IN = 'NOT IN';
    case BETWEEN = 'BETWEEN';
    case NOT_BETWEEN = 'NOT BETWEEN';
    case EXISTS = 'EXISTS';
    case NOT_EXISTS = 'NOT EXISTS';
}