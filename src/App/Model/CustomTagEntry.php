<?php declare(strict_types=1);
namespace App\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Attribute\CustomField;
use Mvc4Wp\Core\Model\Attribute\CustomTaxonomy;
use Mvc4Wp\Core\Model\TagEntity;

#[CustomTaxonomy(name: 'custom_tag', title: 'カスタムタグ', targets: ['post', 'example'])]
class CustomTagEntry extends TagEntity
{
    use Castable;

    #[CustomField(title: 'テキスト例', type: CustomField::TEXT)]
    public string $tag_text = '';
}