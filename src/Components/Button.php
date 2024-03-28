<?php

namespace Dashboard\Components;

use Dashboard\Template\Template;

class Button
{
    public static function create(string $name, string $design = 'btn-primary')
    {
        echo Template::getTemplate('components/button.php', [
            'name' => $name,
            'design' => $design
        ]);
    }
}