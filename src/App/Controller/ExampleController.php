<?php declare(strict_types=1);
namespace App\Controller;

use App\Model\CustomCatEntity;
use App\Model\CustomTagEntity;
use App\Model\ExampleEntity;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\Repository\CompareInQuery;
use Mvc4Wp\Core\Model\Repository\OrderInQuery;
use Mvc4Wp\Core\Model\Repository\TaxQueryFieldInQuery;
use Mvc4Wp\Core\Model\Repository\TypeInQuery;
use Mvc4Wp\Core\Service\App;
use Mvc4Wp\Core\Service\Logging;

class ExampleController extends AdminController
{
    use Castable;

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

    private string $name;

    private array $categories;

    private array $tags;

    public function init(array $args = []): void
    {
        parent::init($args);
        $this->name = 'Example';
        $this->categories = CustomCatEntity::find()
            ->showEmpty()
            ->orderByID()
            ->build()
            ->list();
        $this->tags = CustomTagEntity::find()
            ->showEmpty()
            ->orderByID()
            ->build()
            ->list();
    }

    public function index(array $args = []): void
    {
        $this->list();
    }

    public function list(array $args = [], array $errors = [], $post = []): void
    {
        debug_add_start();

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
        $examples = ExampleEntity::find()
            ->withAutoDraft()
            ->withDraft()
            ->withPublish()
            ->withTrash()
            ->orderBy($sort, $order)
            ->limitOf($per_page, $page)
            ->all()
            ->build()
            ->list();

        $data = [
            'title' => $this->name,
            'count' => count($examples),
            'examples' => $examples,
            'categories' => $this->categories,
            'tags' => $this->tags,
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

        debug_add_end('timer', ['name' => 'list']);

        $this
            ->ok()
            ->view('header', $data)
            ->view('link', $data)
            ->view('example/list', $data)
            ->view('footer');

        $this->done();
    }

    public function search(): void
    {
        $sort = $_POST['sort'];
        $order = OrderInQuery::from(strtoupper($_POST['order']));
        $query = ExampleEntity::find()
            ->withAny()
            ->withAutoDraft()
            ->withTrash()
            ->by($_POST['key'], $_POST['value'], CompareInQuery::from(strtoupper($_POST['compare'])), TypeInQuery::from(strtoupper($_POST['type'])));
        if (array_key_exists('categories', $_POST)) {
            $query = $query->byTaxonomy('custom_cat', array_keys($_POST['categories']), TaxQueryFieldInQuery::SLUG);
        }
        if (array_key_exists('tags', $_POST)) {
            $query = $query->byTaxonomy('custom_tag', array_keys($_POST['tags']), TaxQueryFieldInQuery::SLUG);
        }
        $examples = $query
            ->orderBy($sort, $order)
            ->build()
            ->list();

        $data = [
            'title' => $this->name,
            'count' => count($examples),
            'examples' => $examples,
            'categories' => $this->categories,
            'tags' => $this->tags,
            'columns' => self::COLUMNS,
            'searchable_columns' => self::SEARCHABLE_COLUMNS,
            'registerable_columns' => self::REGISTERABLE_COLUMNS,
            'editable_columns' => self::EDITABLE_COLUMNS,
            'key' => $_POST['key'],
            'value' => $_POST['value'],
            'compare' => $_POST['compare'],
            'type' => $_POST['type'],
        ];

        $this
            ->ok()
            ->view('header', $data)
            ->view('link', $data)
            ->view('example/list', $data)
            ->view('footer')
            ->done();
    }

    public function single(array $args, array $errors = [], array $post = []): void
    {
        $example = null;

        if (array_key_exists('id', $args)) {
            $id = intval($args['id']);
            $example = ExampleEntity::findByID($id, false);
        } elseif (array_key_exists('slug', $args)) {
            $slug = strval($args['slug']);
            $example = ExampleEntity::find()
                ->withAny()
                ->withAutoDraft()
                ->withTrash()
                ->bySlug($slug)
                ->build()
                ->single();
        }
        if (is_null($example)) {
            $this
                ->notFound()
                ->done();
        }
        $id = $example->ID;

        $data = [
            'title' => $this->name,
            'id' => $id,
            'count' => 1,
            'examples' => [$example],
            'categories' => $this->categories,
            'tags' => $this->tags,
            'columns' => self::COLUMNS,
            'searchable_columns' => self::SEARCHABLE_COLUMNS,
            'registerable_columns' => self::REGISTERABLE_COLUMNS,
            'editable_columns' => self::EDITABLE_COLUMNS,
            'errors' => $errors,
            'post' => $post,
            'messager' => App::get()->messager(),
        ];

        $this
            ->ok()
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
            Logging::get('log_model')->info(static::class . '->' . 'register', get_object_vars($example));
            $id = $example->register();
            if (array_key_exists('categories', $_POST)) {
                $categories = array_map(fn($slug) => CustomCatEntity::findBySlug($slug), array_keys($_POST['categories']));
                $example->setCategories($categories);
            }
            if (array_key_exists('tags', $_POST)) {
                $tags = array_map(fn($slug) => CustomTagEntity::findBySlug($slug), array_keys($_POST['tags']));
                $example->setTags($tags);
            }
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
            $this
                ->notFound()
                ->done();
        }

        $errors = $example->validate($_POST);
        if (empty($errors)) {
            $example->bind($_POST);
            Logging::get('log_model')->info(static::class . '->' . 'update', get_object_vars($example));
            $example->update();
            if (array_key_exists('categories', $_POST)) {
                $categories = array_map(fn($slug) => CustomCatEntity::findBySlug($slug), array_keys($_POST['categories']));
                $example->setCategories($categories);
            } else {
                $example->removeCategories(CustomCatEntity::class);
            }
            if (array_key_exists('tags', $_POST)) {
                $tags = array_map(fn($slug) => CustomTagEntity::findBySlug($slug), array_keys($_POST['tags']));
                $example->setTags($tags);
            } else {
                $example->removeTags(CustomTagEntity::class);
            }
            $this
                ->seeOther("/example/{$id}")
                ->done();
        } else {
            $this->single($args, $errors);
        }
    }

    public function delete(array $args): void
    {
        $id = intval($args['id']);
        $example = ExampleEntity::findByID($id, false);
        if (is_null($example)) {
            $this
                ->notFound()
                ->done();
        }

        if ($_POST['delete'] === 'untrash') {
            $example->post_status = 'publish';
            $example->update();
            $this
                ->seeOther("/example/{$id}")
                ->done();
        } elseif ($_POST['delete'] === 'trash') {
            $example->delete();
            $this
                ->seeOther("/example/{$id}")
                ->done();
        } else {
            Logging::get('log_model')->info(static::class . '->' . 'delete', get_object_vars($example));
            $example->delete(true);
            $this
                ->seeOther("/example/list")
                ->done();
        }
    }
}