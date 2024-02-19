<?php declare(strict_types=1);
namespace App\Controller;

use Mvc4Wp\System\Controllers\JsonController;
use Mvc4Wp\System\Core\Cast;

class ApiController extends JsonController
{
    use Cast;

    public function init(array $args = []): void
    {
    }

    public function index(array $args = []): void
    {
        $this->get($args);
    }

    public function get(array $args = []): void
    {
        $data = [
            'title' => 'ajax',
            'value' => 123,
        ];

        $this->ok();
        $this->view(json_encode($data))->done();
    }

    public function post(array $args = []): void
    {
        $this->ok();
        $this->view(json_encode($_POST))->done();
    }
}