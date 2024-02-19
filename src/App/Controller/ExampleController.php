<?php declare(strict_types=1);
namespace App\Controller;

use App\Models\ExampleModel;
use Mvc4Wp\System\Core\Cast;
use Mvc4Wp\System\Service\Logging;

class ExampleController extends AdminController
{
    use Cast;

    private string $name;

    private const META_COLUMNS = [
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

    public function init(array $args = []): void
    {
        parent::init($args);
        $this->name = 'Example';
    }

    public function index(array $args = []): void
    {
        $this->list();
    }

    public function list(array $args = [], array $errors = [], $post = []): void
    {
        $sort = 'ID';
        $order = 'asc';
        $page = 1;
        $per_page = -1;
        if (array_key_exists('sort', $args)) {
            $sort = $args['sort'];
        }
        if (array_key_exists('order', $args)) {
            $order = $args['order'];
        }
        if (array_key_exists('page', $args)) {
            $page = intval($args['page']);
        }
        if (array_key_exists('per_page', $args)) {
            $per_page = intval($args['per_page']);
        }
        $query =  ExampleModel::find()
            ->withDraft()
            ->withTrash()
            ->order($sort, $order);
        $count = $query->all()->count();
        $examples = $query->page($page, $per_page)->get();

        $data = [
            'title' => $this->name,
            'count' => $count,
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
            ->view('link', $data)
            ->view('example/list', $data)
            ->view('footer')
            ->done();
    }

    public function search(): void
    {
        $sort = $_POST['sort'];
        $order = $_POST['order'];
        $examples = ExampleModel::find()
            ->withDraft()
            ->withTrash()
            ->search($_POST['key'], $_POST['value'], $_POST['compare'], $_POST['type'])
            ->order($sort, $order)
            ->get();
        $data = [
            'title' => $this->name,
            'count' => count($examples),
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
            ->view('link', $data)
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
            'count' => 1,
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
            ->view('link', $data)
            ->view('example/single', $data)
            ->view('footer')
            ->done();
    }

    public function register(): void
    {
        $example = new ExampleModel();
        $errors = $example->bind($_POST);
        if (empty($errors)) {
            Logging::get('model')->info(static::class . '->' . 'register', get_object_vars($example));
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
            Logging::get('model')->info(static::class . '->' . 'update', get_object_vars($example));
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
            Logging::get('model')->info(static::class . '->' . 'delete', get_object_vars($example));
            $example->delete();
            $this->seeOther("/example/{$id}")->done();
        } else {
            $example->delete(true);
            $this->seeOther("/example/list")->done();
        }
    }
}