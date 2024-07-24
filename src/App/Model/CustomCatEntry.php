<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\CustomTaxonomy;
use Mvc4Wp\Core\Model\CategoryEntity;

#[CustomTaxonomy(name: 'custom_cat', targets: ['example'], title: 'カスタムカテゴリー', hierarhical: true)]
class CustomCatEntry extends CategoryEntity
{
    use Castable;

    #[CustomField(title: 'ほげ')]
    public string $hoge;

    #[CustomField(title: 'ふが')]
    public string $fuga;
}