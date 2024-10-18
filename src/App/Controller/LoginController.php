<?php declare(strict_types=1);
namespace App\Controller;

use Mvc4Wp\Core\Controller\PlainPhpController;
use Mvc4Wp\Core\Library\Castable;
use Mvc4Wp\Core\Model\UserEntity;
use Mvc4Wp\Core\Service\Logging;

class LoginController extends PlainPhpController
{
    use Castable;

    public function init(array $args = []): void
    {
    }

    public function index(array $args = []): void
    {
        if (UserEntity::current()) {
            $this
                ->seeOther('/')
                ->done();
        } else {
            $this
                ->ok()
                ->view('login')
                ->done();
        }
    }

    public function login(array $args = []): void
    {
        Logging::get('log_model')->info('login', $_POST);
        $_POST['log'] = $_POST['id'];
        $_POST['pwd'] = $_POST['password'];
        require ABSPATH . '/wp-login.php';
    }

    public function logout(array $args = []): void
    {
        Logging::get('log_model')->info('logout', $args);
        wp_logout();
        $this->seeOther('/');
    }

    public function error(array $args = []): void
    {
        debug_add_var('login_error', $args[0]);
        $error_code = $args[0]->get_error_code(); // 'empty_password', 'empty_email', 'invalid_email', 'invalidcombo', 'empty_username', 'invalid_username', 'incorrect_password', 'retrieve_password_email_failure'
        $this
            ->ok()
            ->view('login', ['error' => $error_code])
            ->done();
    }
}