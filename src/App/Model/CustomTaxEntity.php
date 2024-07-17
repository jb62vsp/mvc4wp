<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\CustomTaxonomy;
use Mvc4Wp\Core\Model\TagEntity;

#[CustomTaxonomy(name: 'custom_tax', targets: ['example'], title: 'カスタムタクソノミー')]
class CustomTaxEntity extends TagEntity
{
    use Castable;

    #[CustomField(title: 'ほげ')]
    public string $hoge;

    #[CustomField(title: 'ふが')]
    public string $fuga;
}