<?php

namespace Dashboard;

use Dashboard\Template\AbstractTemplate;
use Dashboard\Template\TemplateInterface;

class Change implements TemplateInterface
{
    protected string $url = "/login-change";
    private string $menu_name = "Change Login";

    public function generate()
    {
        echo 'alterar senha';
    }
}