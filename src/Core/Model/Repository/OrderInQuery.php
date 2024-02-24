<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

enum OrderInQuery: string
{
    case ASC = 'ASC';
    case DESC = 'DESC';
}