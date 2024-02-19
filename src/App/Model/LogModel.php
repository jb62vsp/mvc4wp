<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Models\CustomPostType;
use Mvc4Wp\System\Models\PostModel;
use Mvc4Wp\System\Models\PostType;

#[PostType(name: 'log')]
#[CustomPostType(name: 'log', title: 'ログ')]
class LogModel extends PostModel
{
    use Cast;
}