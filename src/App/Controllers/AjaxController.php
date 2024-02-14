<?php declare(strict_types=1);
namespace App\Controllers;

use System\Controllers\JsonController;
use System\Core\Cast;

class AjaxController extends JsonController
{
    use Cast;

    public function index(): void
    {
        $data = [
            'this' => $this,
            'title' => 'hello',
            'test' => 'world',
        ];

        $this->ok();
        $this->view(json_encode($data))->done();
    }
}