<?php declare(strict_types=1);
namespace Mvc4Wp\Core\Model;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\PostType;

/**
 * @template TModel of PostEntity
 * @extends Model<TModel>
 */
#[Entity]
abstract class PostEntity extends Model
{
    use Castable;

    #[Bindable]
    public int $post_author;

    #[Bindable]
    public string $post_date;

    #[Bindable]
    public string $post_name;

    #[Bindable]
    public string $post_status;

    #[Bindable]
    public string $post_title;

    #[Bindable]
    public string $post_type;

    #[Bindable]
    public string $post_content;
}