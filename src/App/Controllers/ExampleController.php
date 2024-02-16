<?php declare(strict_types=1);
namespace App\Controllers;

use App\Models\ExampleModel;
use System\Core\Cast;

class ExampleController extends AdminController
{
    use Cast;

    private string $name;

    private const COLUMNS = [
        'ID',
        'post_author',
        'post_date',
        'post_name',
        'post_status',
        'post_title',
        'post_type',
        'post_content',
        'example_text',
        'example_textarea',
        'example_int',
        'example_uint',
        'example_float',
        'example_ufloat',
        'example_bool',
        'example_date',
        'example_time',
        'example_datetime',
    ];

    private const SEARCHABLE_COLUMNS = [
        'example_text',
        'example_textarea',
        'example_int',
        'example_uint',
        'example_float',
        'example_ufloat',
        'example_bool',
        'example_date',
        'example_time',
        'example_datetime',
    ];

    private const REGISTERABLE_COLUMNS = [
        'post_title',
        'post_content',
        'example_text',
        'example_textarea',
        'example_int',
        'example_uint',
        'example_float',
        'example_ufloat',
        'example_bool',
        'example_date',
        'example_time',
        'example_datetime',
    ];

    private const EDITABLE_COLUMNS = [
        'post_author',
        'post_date',
        'post_name',
        'post_status',
        'post_title',
        'post_type',
        'post_content',
        'example_text',
        'example_textarea',
        'example_int',
        'example_uint',
        'example_float',
        'example_ufloat',
        'example_bool',
        'example_date',
        'example_time',
        'example_datetime',

    ];

    public function init(): void
    {
        parent::init();
        $this->name = 'Example';
    }

    public function index(): void
    {
        $this->list();
    }

    public function list(array $args = [], array $errors = [], $post = []): void
    {
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
            'title' => $this->name,
            'examples' => $examples,
            'columns' => self::COLUMNS,
            'searchable_columns' => self::SEARCHABLE_COLUMNS,
            'registerable_columns' => self::REGISTERABLE_COLUMNS,
            'editable_columns' => self::EDITABLE_COLUMNS,
            'sort' => $sort,
            'order' => $order,
            'errors' => $errors,
            'post' => $post,
            'list' => true,
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('example/list', $data)
            ->view('footer')
            ->done();
    }

    public function search(): void
    {
        $sort = 'ID';
        $order = 'asc';
        $examples = ExampleModel::find()
            ->withDraft()
            ->withTrash()
            ->search($_POST['key'], $_POST['value'], $_POST['compare'], $_POST['type'])
            ->order($sort, $order)
            ->get();
        $data = [
            'title' => $this->name,
            'examples' => $examples,
            'columns' => self::COLUMNS,
            'searchable_columns' => self::SEARCHABLE_COLUMNS,
            'registerable_columns' => self::REGISTERABLE_COLUMNS,
            'editable_columns' => self::EDITABLE_COLUMNS,
            'key' => $_POST['key'],
            'value' => $_POST['value'],
            'compare' => $_POST['compare'],
            'type' => $_POST['type'],
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('example/list', $data)
            ->view('footer')
            ->done();
    }

    public function single(array $args, array $errors = [], array $post = []): void
    {
        $id = intval($args['id']);
        $example = ExampleModel::find()->withDraft()->withTrash()->byID($id);
        if (is_null($example)) {
            $this->notFound()->done();
        }

        $data = [
            'title' => $this->name,
            'id' => $id,
            'examples' => [$example],
            'columns' => self::COLUMNS,
            'searchable_columns' => self::SEARCHABLE_COLUMNS,
            'registerable_columns' => self::REGISTERABLE_COLUMNS,
            'editable_columns' => self::EDITABLE_COLUMNS,
            'errors' => $errors,
            'post' => $post,
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
        $errors = $example->bind($_POST);
        if (empty($errors)) {
            $id = $example->register();
            $this->seeOther("/example/{$id}")->done();
        } else {
            $this->list([], $errors, $_POST);
        }
    }

    public function update(array $args): void
    {
        $id = intval($args['id']);
        $example = ExampleModel::cast_null(ExampleModel::find()->withDraft()->withTrash()->byID($id));
        if (is_null($example)) {
            $this->notFound()->done();
        }

        $errors = $example->bind($_POST);
        if (empty($errors)) {
            $example->update();
            $this->seeOther("/example/{$id}")->done();
        } else {
            $this->single($args, $errors);
        }
    }

    public function delete(array $args): void
    {
        $id = intval($args['id']);
        $example = ExampleModel::cast_null(ExampleModel::find()->withDraft()->withTrash()->byID($id));
        if (is_null($example)) {
            $this->notFound()->done();
        }

        if ($_POST['to_trush'] === 'true') {
            $example->delete();
            $this->seeOther("/example/{$id}")->done();
        } else {
            $example->delete(true);
            $this->seeOther("/example/list")->done();
        }
    }
}