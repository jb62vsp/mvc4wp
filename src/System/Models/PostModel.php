<?php declare(strict_types=1);
namespace System\Models;

use System\Core\Cast;

#[PostType(name: 'post')]
class PostModel extends Model
{
    use Cast;

    #[Bindable]
    protected int $post_author;

    #[Bindable]
    protected string $post_date;

    #[Bindable]
    protected string $post_name;

    #[Bindable]
    protected string $post_status;

    #[Bindable]
    protected string $post_title;

    #[Bindable]
    protected string $post_type;

    #[Bindable]
    protected string $post_content;

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