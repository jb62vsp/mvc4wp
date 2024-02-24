<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;


interface QueryBuilderInterface
{
    public function build(): QueryExecutorInterface;
}