<?php declare(strict_types=1);
namespace App\Models;

use System\Core\Cast;
use System\Models\CustomPostType;
use System\Models\PostModel;
use System\Models\PostType;

#[PostType(name: 'log')]
#[CustomPostType(slug: 'log', title: 'ログ')]
class LogModel extends PostModel
{
    use Cast;
}