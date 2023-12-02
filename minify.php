<?php

require_once 'vendor/autoload.php';

use MatthiasMullie\Minify\{CSS, JS};

$dir_css = "src/templates/assets/vendor/css/";
$dir_js = "src/templates/assets/vendor/js/";

$minCSS = new CSS();
$cssDir = scandir($dir_css);

foreach ($cssDir as $cssItem) {
    $cssFile = $dir_css . $cssItem;

    if (is_file($cssFile) && pathinfo($cssFile)["extension"] == "css") {
        $minCSS->add($cssFile);
    }
}

$minCSS->minify('src/templates/assets/style.min.css');

$minJS = new JS();
$jsDir = scandir($dir_js);

foreach ($jsDir as $jsItem) {
    $jsFile = $dir_js . $jsItem;

    if (is_file($jsFile) && pathinfo($jsFile)["extension"] == "js") {
        $minJS->add($jsFile);
    }
}

$minJS->minify('src/templates/assets/script.min.js');
