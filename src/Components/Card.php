<?php

namespace Dashboard\Components;

use Dashboard\HelpersTrait;
use Dashboard\Template\Template;

class Card
{
    public static function generate()
    {
        echo Template::getTemplate('components/card.php');
    }

    public static function charts()
    {
        echo Template::getTemplate('components/charts.php');
    }
}