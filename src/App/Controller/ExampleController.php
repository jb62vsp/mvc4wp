<?php declare(strict_types=1);
namespace App\Controller;

use App\Model\ExampleEntity;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\CompareInQuery;
use Mvc4Wp\Core\Model\Repository\OrderInQuery;
use Mvc4Wp\Core\Model\Repository\TypeInQuery;
use Mvc4Wp\Core\Service\App;
use Mvc4Wp\Core\Service\Logging;

class ExampleController extends AdminController
{
    use Castable;

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

    private const SORTABLE_COLUMNS = [
        'ID',
        'post_author',
        'post_date',
        'post_name',
        'post_title',
        'post_type',
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
        $order = OrderInQuery::ASC;
        $page = 1;
        $per_page = -1;
        if (array_key_exists('sort', $args)) {
            $sort = $args['sort'];
        }
        if (array_key_exists('order', $args)) {
            $order = OrderInQuery::from(strtoupper($args['order']));
        }
        if (array_key_exists('page', $args)) {
            $page = intval($args['page']);
        }
        if (array_key_exists('per_page', $args)) {
            $per_page = intval($args['per_page']);
        }
        $query = ExampleEntity::find()
            ->withAutoDraft()
            ->withDraft()
            ->withPublish()
            ->withTrash()
            ->orderBy($sort, $order)
            ->limitOf($per_page, $page)
            ->all()
        ;
        ;
        $count = $query->build()->count();
        $examples = $query->build()->list();

        $data = [
            'title' => $this->name,
            'count' => $count,
            'examples' => $examples,
            'columns' => self::COLUMNS,
            'sortable_columns' => self::SORTABLE_COLUMNS,
            'searchable_columns' => self::SEARCHABLE_COLUMNS,
            'registerable_columns' => self::REGISTERABLE_COLUMNS,
            'editable_columns' => self::EDITABLE_COLUMNS,
            'sort' => $sort,
            'order' => strtolower($order->value),
            'errors' => $errors,
            'post' => $post,
            'list' => true,
            'messager' => App::get()->messager(),
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
        $order = OrderInQuery::from(strtoupper($_POST['order']));
        $examples = ExampleEntity::find()
            ->withAny()
            ->withAutoDraft()
            ->withTrash()
            ->by($_POST['key'], $_POST['value'], CompareInQuery::from(strtoupper($_POST['compare'])), TypeInQuery::from(strtoupper($_POST['type'])))
            ->orderBy($sort, $order)
            ->build()
            ->list()
        ;
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
        $example = ExampleEntity::findByID($id, false);
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
            'messager' => App::get()->messager(),
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
        $example = new ExampleEntity();
        $errors = $example->validate($_POST);
        if (empty($errors)) {
            $example->bind($_POST);
            Logging::get('log_post')->info(static::class . '->' . 'register', get_object_vars($example));
            $id = $example->register();
            $this->seeOther("/example/{$id}")->done();
        } else {
            $this->list([], $errors, $_POST);
        }
    }

    public function update(array $args): void
    {
        $id = intval($args['id']);
        $example = ExampleEntity::findByID($id, false);
        if (is_null($example)) {
            $this->notFound()->done();
        }

        $errors = $example->validate($_POST);
        if (empty($errors)) {
            $example->bind($_POST);
            Logging::get('log_post')->info(static::class . '->' . 'update', get_object_vars($example));
            $example->update();
            $this->seeOther("/example/{$id}")->done();
        } else {
            $this->single($args, $errors);
        }
    }

    public function delete(array $args): void
    {
        $id = intval($args['id']);
        $example = ExampleEntity::findByID($id, false);
        if (is_null($example)) {
            $this->notFound()->done();
        }

        if ($_POST['to_trush'] === 'true') {
            Logging::get('log_post')->info(static::class . '->' . 'delete', get_object_vars($example));
            $example->delete();
            $this->seeOther("/example/{$id}")->done();
        } else {
            $example->delete(true);
            $this->seeOther("/example/list")->done();
        }
    }
}