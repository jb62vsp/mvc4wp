<?php declare(strict_types=1);
namespace App\Controller;

use Mvc4Wp\System\Controllers\PlainPhpController;
use Mvc4Wp\System\Core\Cast;

class HomeController extends PlainPhpController
{
    use Cast;

    private string $name;

    public function init(array $args = []): void
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

    public function index(array $args = []): void
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

    public function redirect(array $args = []): void
    {
        $this->seeOther('/home/other/321')->done();
    }
}