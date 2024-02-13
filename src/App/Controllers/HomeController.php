<?php

namespace App\Controllers;

use System\Controllers\Controller;

class HomeController extends Controller
{
    private string $name;

    public function init(): void
    {
        $this->name = 'HomeController';
    }

    public function index(): void
    {
        $this->ok();
        $this
            ->view('header', [
                'title' => $this->name,
            ])
            ->view('body', [
                'test' => 'world',
            ])
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

        $this->ok();
        $this
            ->view('header', [
                'title' => $this->name,
            ])
            ->view('body', [
                'test' => $id,
            ])
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