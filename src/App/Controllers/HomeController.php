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
        $this->name = 'HomeController';
    }

    public function index(): void
    {
        $data = [
            'this' => $this,
            'title' => $this->name,
            'test' => 'world',
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
            $this->notFound()
                ->done();
        }

        $data = [
            'this' => $this,
            'title' => $this->name,
            'test' => 'world',
        ];

        $this->ok();
        $this
            ->view('header', $data)
            ->view('home/body', $data)
            ->view('footer')
            ->done();
    }

    public function redirect(): void
    {
        $this->seeOther('/home/other/321')->done();
    }

    public function register(): void
    {
        $sample = $_POST['sample'];
        $this->seeOther('/')->done();
    }

    public function update(array $args): void
    {
        $this->seeOther("/home/other/{$args['id']}")->done();
    }

    public function delete(array $args): void
    {
        $this->seeOther("/home/other/{$args['id']}")->done();
    }
}