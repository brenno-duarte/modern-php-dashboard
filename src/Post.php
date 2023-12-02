<?php

namespace Dashboard;

use Dashboard\Resource\Messages;
use Dashboard\Template\AbstractTemplate;
use Dashboard\Template\TemplateInterface;

class Post implements TemplateInterface
{
    protected string $url = "/cadastrar";
    private string $menu_name = "Cadastrar";

    public function generate()
    {
        echo 'Cadastrar';
        var_dump($_POST);
    }

    public function handle()
    {
        $user = new Register;

        if (isset($_POST['id'])) {
            $user->id = $_POST['id'];

            Messages::add('edit', 'Resource edited');
        } else {
            Messages::add('add', 'Resource added');
        }

        $user->email = $_POST['email'];
        $user->username = $_POST['username'];
        $user->password = $_POST['password'];
        $user->save();

        Router::toRoute('/clientes');
    }
}
