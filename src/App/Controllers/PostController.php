<?php declare(strict_types=1);
namespace App\Controllers;

use System\Controllers\PlainPhpController;
use System\Core\Cast;
use System\Models\PostModel;

class PostController extends PlainPhpController
{
    use Cast;

    private string $name;

    public function init(): void
    {
        $this->name = 'Post';
    }

    public function index(): void
    {
        $this->list();
    }

    public function list(array $args = []): void
    {
        $posts = [];
        $sort = 'ID';
        $order = 'asc';
        if (array_key_exists('sort', $args)) {
            $sort = $args['sort'];
        }
        if (array_key_exists('order', $args)) {
            $order = $args['order'];
        }
        $posts = PostModel::find()->withDraft()->withTrash()->order($sort, $order)->get();

        $data = [
            'this' => $this,
            'title' => $this->name,
            'posts' => $posts,
            'columns' => ['ID', 'post_author', 'post_date', 'post_name', 'post_status', 'post_title', 'post_type', 'post_content',],
            'sort' => $sort,
            'order' => $order,
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('post/list', $data)
            ->view('footer')
            ->done();
    }

    public function single(array $args): void
    {
        $id = intval($args['id']);
        $post = PostModel::find()->withDraft()->withTrash()->byID($id);
        if (is_null($post)) {
            $this->notFound()->done();
        }

        $data = [
            'this' => $this,
            'title' => $this->name,
            'id' => $id,
            'posts' => [$post],
            'columns' => ['ID', 'post_author', 'post_date', 'post_name', 'post_status', 'post_title', 'post_type', 'post_content',],
            'single' => 'true',
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('post/single', $data)
            ->view('footer')
            ->done();
    }

    public function register(): void
    {
        $post = new PostModel();
        $post->bind($_POST);
        $id = $post->register();
        $this->seeOther("/post/{$id}")->done();
    }

    public function update(array $args): void
    {
        $id = intval($args['id']);
        $post = PostModel::cast_null(PostModel::find()->withDraft()->withTrash()->byID($id));
        if (is_null($post)) {
            $this->notFound()->done();
        }

        $post->bind($_POST);
        $post->update();
        $this->seeOther("/post/{$id}")->done();
    }

    public function delete(array $args): void
    {
        $id = intval($args['id']);
        $post = PostModel::cast_null(PostModel::find()->byID($id));
        if (is_null($post)) {
            $this->notFound()->done();
        }

        $post->delete();
        $this->seeOther("/post/list")->done();
    }
}