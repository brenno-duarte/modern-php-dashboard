<?php

namespace Dashboard;

use Dashboard\Auth\Login;
use Dashboard\Template\Template;

class Router
{
    private static array $routers = [];

    public static function register(array $routers)
    {
        self::$routers = $routers;
    }

    public static function getRouters()
    {
        return self::$routers;
    }

    public static function toRoute(string $router)
    {
        $redirect = Template::redirect($router);
        exit(header("Location: " . $redirect));
    }

    /* public function middlewareLogin()
    {
        $login = new Login;
        //$login->auth();
        dd($login->setAuth());

        if ($login->isUserLoggedIn($user) == false) {
            header('Location: index.php');
            exit;
        }
    } */
}