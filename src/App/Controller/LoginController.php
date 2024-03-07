<?php declare(strict_types=1);
namespace App\Controller;

use Mvc4Wp\Core\Controller\PlainPhpController;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\UserEntity;

class LoginController extends PlainPhpController
{
    use Castable;

    public function init(array $args = []): void
    {
    }

    public function index(array $args = []): void
    {
        if (UserEntity::current()) {
            $this->seeOther('/')->done();
        } else {
            $this->ok();
            $this->view('login')->done();
        }
    }

    public function login(array $args = []): void
    {
        require ABSPATH . '/wp-login.php';
    }

    public function logout(array $args = []): void
    {
        wp_logout();
        $this->seeOther('/');
    }
}