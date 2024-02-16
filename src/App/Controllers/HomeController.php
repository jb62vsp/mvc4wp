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

    public function index(): void
    {
        $data = [
            'title' => $this->name,
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('home/body', $data)
            ->view('footer')
            ->done();
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
        $this
            ->view('header', $data)
            ->view('home/body', $data)
            ->view('home/other', $data)
            ->view('footer')
            ->done();
    }

    public function redirect(): void
    {
        $this->seeOther('/home/other/321')->done();
    }
}