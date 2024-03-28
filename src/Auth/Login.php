<?php

namespace Dashboard\Auth;

use Dashboard\HelpersTrait;
use Dashboard\Resource\Messages;
use Dashboard\Router;
use Dashboard\Template\AbstractTemplate;
use Katrina\Connection\Connection;

class Login extends AbstractTemplate
{
    use HelpersTrait;

    protected string $url = "/login-php-dashboard";

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function generate($get_parameter = null)
    {
        if (isset($get_parameter[1])) {
            if (str_contains($get_parameter[1], "logout=true")) {
                $this->logout();
            }
        }

        $auth = $this->setAuth();
        $check = $auth->check($_POST['username'], $_POST['password']);

        if ($check == true) {
            $auth->login($_POST['username']);
            
            Router::toRoute('/dashboard');
        } else {
            Messages::add("error-login", "E-mail or password invalid", "danger");
            Router::toRoute('');
        }

    }

    public function auth()
    {
        $katrina = Connection::getInstance();
        $auth = new Auth($katrina);

        return $auth;
    }

    public function setAuth()
    {
        $auth = $this->auth();
        $auth->setUsersTableName('users');
        $auth->setEmailField('username');
        $auth->setPasswordField('password');
        $auth->setLoginField('email');

        return $auth;
    }

    public static function isLogged()
    {
        if (!isset($_SESSION['user'])) {
            Messages::add("error-login,", "User is not logged in", "danger");
            Router::toRoute('');
        }
    }

    public function logout()
    {
        $auth = $this->auth();
        $auth->logout($_SESSION['user']);
        Messages::add("logout", "Logout successful!", "success");
        Router::toRoute('');
    }

    public function getUsername(): ?string
    {
        return session()->get('username');
    }

    /* public function setUsername(string $user): Login
    {
        session()->put('username', $user);
        return $this;
    } */
}
