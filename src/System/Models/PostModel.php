<?php declare(strict_types=1);
namespace System\Models;

use System\Core\Cast;

#[PostType('post')]
class PostModel extends Model
{
    use Cast;

    #[BindableField]
    public int $post_author;

    #[BindableField]
    public string $post_date;

    #[BindableField]
    public string $post_name;

    #[BindableField]
    public string $post_status;

    #[BindableField]
    public string $post_title;

    #[BindableField]
    public string $post_type;

    #[BindableField]
    public string $post_content;
}