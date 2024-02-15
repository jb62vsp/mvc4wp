<?php declare(strict_types=1);
namespace App\Controllers;

use App\Models\ExampleModel;
use System\Controllers\PlainPhpController;
use System\Core\Cast;

class ExampleController extends PlainPhpController
{
    use Cast;

    private string $name;

    public function init(): void
    {
        $this->name = 'Example';
    }

    public function index(): void
    {
        $this->list();
    }

    public function list(array $args = []): void
    {
        $examples = [];
        $sort = 'ID';
        $order = 'asc';
        if (array_key_exists('sort', $args)) {
            $sort = $args['sort'];
        }
        if (array_key_exists('order', $args)) {
            $order = $args['order'];
        }
        $examples = ExampleModel::find()->withDraft()->withTrash()->order($sort, $order)->get();

        $data = [
            'this' => $this,
            'title' => $this->name,
            'examples' => $examples,
            'columns' => [
                'ID',
                'post_author',
                'post_date',
                'post_name',
                'post_status',
                'post_title',
                'post_type',
                'post_content',
                'example_string',
                'example_int',
                'example_float',
                'example_bool',
                'example_datetime',
            ],
            'sort' => $sort,
            'order' => $order,
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('example/list', $data)
            ->view('footer')
            ->done();
    }

    public function single(array $args): void
    {
        $id = intval($args['id']);
        $example = ExampleModel::find()->withDraft()->withTrash()->byID($id);
        if (is_null($example)) {
            $this->notFound()->done();
        }

        $data = [
            'this' => $this,
            'title' => $this->name,
            'id' => $id,
            'examples' => [$example],
            'columns' => [
                'ID',
                'post_author',
                'post_date',
                'post_name',
                'post_status',
                'post_title',
                'post_type',
                'post_content',
                'example_string',
                'example_int',
                'example_float',
                'example_bool',
                'example_datetime',
            ],
            'single' => 'true',
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('example/single', $data)
            ->view('footer')
            ->done();
    }

    public function register(): void
    {
        $example = new ExampleModel();
        $example->bind($_POST);
        $id = $example->register();
        $this->seeOther("/example/{$id}")->done();
    }

    public function update(array $args): void
    {
        $id = intval($args['id']);
        $example = ExampleModel::cast_null(ExampleModel::find()->withDraft()->withTrash()->byID($id));
        if (is_null($example)) {
            $this->notFound()->done();
        }

        $example->bind($_POST);
        $example->update();
        $this->seeOther("/example/{$id}")->done();
    }

    public function delete(array $args): void
    {
        $id = intval($args['id']);
        $example = ExampleModel::cast_null(ExampleModel::find()->byID($id));
        if (is_null($example)) {
            $this->notFound()->done();
        }

        $example->delete();
        $this->seeOther("/example/list")->done();
    }
}