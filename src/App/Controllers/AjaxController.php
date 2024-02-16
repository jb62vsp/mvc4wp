<?php declare(strict_types=1);
namespace App\Controllers;

use System\Controllers\JsonController;
use System\Core\Cast;

class AjaxController extends JsonController
{
    use Cast;

    public function index(): void
    {
        $this->get();
    }

    public function get(): void
    {
        $data = [
            'title' => 'ajax',
            'value' => 123,
        ];

        $this->ok();
        $this->view(json_encode($data))->done();
    }

    public function post(): void
    {
        $this->ok();
        $this->view(json_encode($_POST))->done();
    }
}