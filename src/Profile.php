<?php

namespace Dashboard;

use Dashboard\Template\AbstractTemplate;
use Dashboard\Template\Template;
use Katrina\Katrina;

class Profile extends AbstractTemplate
{
    protected string $url = "/profile";
    private string $menu_name = "Profile";

    public function generate()
    {
        echo Template::getTemplate('profile.php');
    }
}