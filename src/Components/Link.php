<?php

namespace Dashboard\Components;

use Dashboard\Template\Template;

class Link
{
    public static function create(
        string $name,
        string $link,
        string $target = '_blank',
        string $design = ''
    ) {
        echo Template::getTemplate('components/link.php', [
            'name' => $name,
            'link' => $link,
            'target' => $target,
            'design' => $design
        ]);
    }
}
