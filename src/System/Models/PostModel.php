<?php declare(strict_types=1);
namespace System\Models;

use System\Core\Cast;

#[PostType(name: 'post')]
class PostModel extends Model
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

    public function __construct()
    {
        $this->post_type = PostType::getName(static::class);
    }

    public function register(bool $publish = true): int
    {
        if ($publish) {
            $this->post_status = 'publish';
        }
        return parent::register();
    }

    public static function find(): PostQuery
    {
        return new PostQuery(static::class);
    }
}