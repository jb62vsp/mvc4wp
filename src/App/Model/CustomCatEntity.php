<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\CustomTaxonomy;
use Mvc4Wp\Core\Model\CategoryEntity;

#[CustomTaxonomy(name: 'custom_cat', targets: ['example',], title: ['en_US' => 'Custom Categories', 'ja' => 'カスタムカテゴリー',], hierarhical: true)]
class CustomCatEntity extends CategoryEntity
{
    use Castable;

    #[CustomField(title: ['en_US' => 'Hoge', 'ja' => 'ほげ',])]
    public string $hoge;

    #[CustomField(title: ['en_US' => 'Fuga', 'ja' => 'ふが',])]
    public string $fuga;
}