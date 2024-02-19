<?php declare(strict_types=1);
namespace Wp4Mvc\System\Models;

use Wp4Mvc\System\Core\Cast;
use Wp4Mvc\System\Models\PostType;

/**
 * @template TModel of PostEntity
 * @extends Model<TModel>
 */
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