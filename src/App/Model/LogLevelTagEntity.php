<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomTaxonomy;
use Mvc4Wp\Core\Model\TagEntity;

#[CustomTaxonomy(name: 'log_level_tag', title: 'ログレベル', targets: ['log',])]
class LogLevelTagEntity extends TagEntity
{
    use Castable;
}