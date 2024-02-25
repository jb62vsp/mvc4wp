<?php declare(strict_types=1);
namespace App\Controller;

use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\PostEntity;
use Mvc4Wp\Core\Model\Repository\OrderInQuery;

class PostController extends AdminController
{
    use Castable;

    private string $name;

    public function init(array $args = []): void
    {
        parent::init($args);
        $this->name = 'Post';
    }

    public function index(array $args = []): void
    {
        $this->list();
    }

    public function list(array $args = []): void
    {
        $posts = [];
        $sort = 'ID';
        $order = OrderInQuery::ASC;
        if (array_key_exists('sort', $args)) {
            $sort = $args['sort'];
        }
        if (array_key_exists('order', $args)) {
            $order = OrderInQuery::from(strtoupper($args['order']));
        }
        $posts = PostEntity::find()
            ->withAutoDraft()
            ->withDraft()
            ->withTrash()
            ->orderBy($sort, $order)
            ->build()
            ->list()
        ;

        $data = [
            'title' => $this->name,
            'posts' => $posts,
            'columns' => ['ID', 'post_author', 'post_date', 'post_name', 'post_status', 'post_title', 'post_type', 'post_content',],
            'sort' => $sort,
            'order' => strtolower($order->value),
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('link', $data)
            ->view('post/list', $data)
            ->view('footer')
            ->done();
    }

    public function single(array $args): void
    {
        $id = intval($args['id']);
        $post = PostEntity::findByID($id, false);
        if (is_null($post)) {
            $this->notFound()->done();
        }

        $data = [
            'title' => $this->name,
            'id' => $id,
            'posts' => [$post],
            'columns' => ['ID', 'post_author', 'post_date', 'post_name', 'post_status', 'post_title', 'post_type', 'post_content',],
            'single' => 'true',
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('link', $data)
            ->view('post/single', $data)
            ->view('footer')
            ->done();
    }

    public function register(array $args = []): void
    {
        $post = new PostEntity();
        $post->bind($_POST);
        $id = $post->register();
        $this->seeOther("/post/{$id}")->done();
    }

    public function update(array $args): void
    {
        $id = intval($args['id']);
        $post = PostEntity::findByID($id, false);
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
        $post = PostEntity::findByID($id, false);
        if (is_null($post)) {
            $this->notFound()->done();
        }

        $post->delete();
        $this->seeOther("/post/list")->done();
    }
}