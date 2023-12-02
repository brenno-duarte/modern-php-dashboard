<?php

namespace Dashboard;

use Dashboard\Form\Form;
use Dashboard\Template\AbstractTemplate;
use Dashboard\Form\FormMethodEnum;
use Dashboard\Template\TemplateInterface;

class Dashboard extends AbstractTemplate implements TemplateInterface
{
    protected string $url = "/dashboard";
    private string $menu_name = "Painel de controle";

    public function generate()
    {
        var_dump($_SESSION);
        /* $form = Form::create(FormMethodEnum::POST, (new Post));
        $form->input('Nome de usuário', 'name', 'username');
        $form->input('E-mail', 'email', 'email');
        $form->input('Senha', 'password', 'password');
        /* $form->input('Option 1', 'radio', 'option');
        $form->input('Option 2', 'radio', 'option'); 
        //$form->input('Remember', 'ranger', options: ['min="100"', 'max="1000"', 'step="100"']);
        $form->submitButton('Enviar');
        $form->render(); */
    }

    public function create()
    {
        
    }

    public function edit($id)
    {
        
    }

    public function delete($id)
    {
        
    }
}
