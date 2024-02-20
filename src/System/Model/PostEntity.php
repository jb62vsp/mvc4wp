<?php declare(strict_types=1);
namespace Mvc4Wp\System\Model;

use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Model\PostType;

/**
 * @template TModel of PostEntity
 * @extends Model<TModel>
 */
#[Entity]
abstract class PostEntity extends Model
{
    use Cast;

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