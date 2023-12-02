<?php

require_once 'vendor/autoload.php';

use Dashboard\Template\Menu;
use Dashboard\Template\Template;
use Dashboard\Client;
use Dashboard\Register;
use Dashboard\Dashboard;
use Dashboard\Auth\Login;
use Dashboard\Post;
use Dashboard\Router;

define('DB_CONFIG', [
    'DRIVE' => 'mysql',
    'HOST' => 'localhost',
    'DBNAME' => 'teste',
    'USER' => 'root',
    'PASS' => ''
]);

Router::register([
    \Dashboard\Post::class
]);

//Login::isLogged();

$menu = new Menu();
$menu->item(Dashboard::class);
$menu->item(Client::class);
//$menu->submenu('Cadastro', [Client::class]);
$menu->create();

(new Template)->render($menu);