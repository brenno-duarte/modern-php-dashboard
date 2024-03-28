<?php

namespace Dashboard;

use Dashboard\Template\AbstractTemplate;

class Change extends AbstractTemplate
{
    protected string $url = "/login-change";
    private string $menu_name = "Change Login";

    public function generate()
    {
        echo 'alterar senha';
    }
}