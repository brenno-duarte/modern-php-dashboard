<?php

namespace Dashboard;

use Dashboard\Form\Form;
use Dashboard\Form\FormMethodEnum;
use Dashboard\Resource\Messages;
use Dashboard\Template\AbstractTemplate;
use Dashboard\Template\TemplateInterface;

class Client extends AbstractTemplate implements TemplateInterface
{
    protected string $url = "/clientes";
    protected string $menu_name = "Clientes";

    public function generate()
    {
        $users = Register::select()->order("id")->get();
        $form = Form::createDataTable($users, ['id', 'username', 'email', 'password']);
        $form->render();
    }

    public function create()
    {
        $form = Form::create(FormMethodEnum::POST, (new Post));
        $form->input('Nome de usuário', 'name', 'username');
        $form->input('E-mail', 'email', 'email');
        $form->input('Senha', 'password', 'password');
        $form->submitButton('Enviar');
        $form->render();
    }

    public function edit($id)
    {
        $users = Register::select()->where('id=' . $id)->getUnique();

        $form = Form::edit($users->id, FormMethodEnum::POST, (new Post));
        $form->input('Nome de usuário', 'name', 'username', value: $users->username);
        $form->input('E-mail', 'email', 'email', value: $users->email);
        $form->input('Senha', 'password', 'password', value: $users->password);
        $form->submitButton('Atualizar');
        $form->render();
    }

    public function delete($id)
    {
        Register::delete('id', $id);
        Messages::add('delete', 'Resource deleted');
        Router::toRoute("/clientes");
    }
}
