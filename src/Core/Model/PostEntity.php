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

    #[Field]
    public int $post_author;

    #[Field]
    public string $post_date;

    #[Field]
    public string $post_name;

    #[Field]
    public string $post_status;

    #[Field]
    public string $post_title;

    #[Field]
    public string $post_type;

    #[Field]
    public string $post_content;
}