<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomPostType;
use Mvc4Wp\Core\Model\Attribute\PostType;
use Mvc4Wp\Core\Model\PostEntity;

#[PostType(name: 'log')]
#[CustomPostType(name: 'log', title: 'ログ', args: ['supports' => ['title', 'editor']])]
class LogEntity extends PostEntity
{
    use Castable;
}