<?php declare(strict_types=1);
namespace App\Models;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\CustomPostType;
use Mvc4Wp\Core\Model\PostModel;

#[CustomPostType(name: 'log', title: 'ログ')]
class LogModel extends PostModel
{
    use Castable;
}