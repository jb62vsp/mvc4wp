<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomPostType;
use Mvc4Wp\Core\Model\PostEntity;
use Mvc4Wp\Core\Model\Repository\Taggable;

#[CustomPostType(name: 'log', title: 'ログ', args: ['supports' => ['title', 'editor']])]
class LogEntity extends PostEntity
{
    use Castable, Taggable;
}