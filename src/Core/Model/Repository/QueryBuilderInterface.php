<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model\Repository;

use Mvc4Wp\Core\Model\Model;

/**
 * @template TModel of Model
 */
interface QueryBuilderInterface
{
    public function build(): QueryExecutorInterface;
}