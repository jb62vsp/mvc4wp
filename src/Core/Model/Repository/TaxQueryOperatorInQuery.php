<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

enum TaxQueryOperatorInQuery: string
{
    case IN = 'IN';
    case NOT_IN = 'NOT IN';
    case AND = 'AND';
    case EXISTS = 'EXISTS';
    case NOT_EXISTS = 'NOT EXISTS';
}