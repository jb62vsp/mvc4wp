<?php declare(strict_types=1);
namespace App\Controllers;

use System\Controllers\PlainPhpController;
use System\Core\Cast;

class HomeController extends PlainPhpController
{
    use Cast;

    private string $name;

    public function init(): void
    {
        $this->name = 'Home';
    }

    private function page(string $view, array $data): self
    {
        $this->ok();
        $this->view('header', $data);
        if (is_user_logged_in()) {
            $this->view('link', $data);
        }
        $this->view($view, $data)
            ->view('footer', $data);
        return $this;
    }

    public function index(): void
    {
        $data = [
            'title' => $this->name,
        ];

        $this->ok();
        $this->page('home/body', $data)->done();
    }

    public function other(array $args): void
    {
        $id = intval($args['id']);
        if ($id === 0) {
            $this->notFound()->done();
        }

        $data = [
            'title' => 'other page',
            'id' => strval($id),
        ];

        $this->ok();
        $this->page('home/body', $data)->done();
    }

    public function redirect(): void
    {
        $this->seeOther('/home/other/321')->done();
    }
}