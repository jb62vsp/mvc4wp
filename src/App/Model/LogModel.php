<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Model\CustomPostType;
use Mvc4Wp\System\Model\PostModel;
use Mvc4Wp\System\Model\PostType;

/**
 * @template TModel of LogModel
 * @extends PostModel<TModel>
 */
#[PostType(name: 'log')]
#[CustomPostType(name: 'log', title: 'ログ')]
class LogModel extends PostModel
{
    use Cast;
}