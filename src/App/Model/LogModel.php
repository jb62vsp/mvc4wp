<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\CustomPostType;
use Mvc4Wp\Core\Model\PostModel;
use Mvc4Wp\Core\Model\PostType;

/**
 * @template TModel of LogModel
 * @extends PostModel<TModel>
 */
#[PostType(name: 'log')]
#[CustomPostType(name: 'log', title: 'ログ')]
class LogModel extends PostModel
{
    use Castable;
}