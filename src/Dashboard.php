<?php

namespace Dashboard;

use Dashboard\Components\Button;
use Dashboard\Components\Card;
use Dashboard\Components\Link;
use Dashboard\Components\Modal;
use Dashboard\Template\AbstractTemplate;
use Dashboard\Template\Template;

class Dashboard extends AbstractTemplate
{
    protected string $url = "/dashboard";
    private string $menu_name = "Painel de controle";

    public function generate()
    {
        Link::create('https://google.com', 'Google');
        Template::breakLine(3);
        Button::create('My Button', 'btn-outline-success rounded');
        Card::charts();

        $modal = new Modal;
        $modal->body("Non omnis incidunt qui sed occaecati magni asperiores est mollitia. Soluta at et reprehenderit. Placeat autem numquam et fuga numquam. Tempora in facere consequatur sit dolor ipsum. Consequatur nemo amet incidunt est facilis. Dolorem neque recusandae quo sit molestias sint dignissimos.");
        $modal->size('modal-lg');
        $modal->render();
        
        //var_dump($_SESSION);
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
}
