<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

enum TaxQueryFieldInQuery: string
{

    case TERM_ID = 'term_id';
    case NAME = 'name';
    case SLUG = 'slug';
    case TERM_TAXONOMY_ID = 'term_taxonomy_id';
}