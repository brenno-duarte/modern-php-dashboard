<?php

namespace Dashboard;

trait HelpersTrait
{
    /* public static function getAsset(string $asset_file): mixed
    {
        if (str_contains("/", $asset_file)) {
            $asset_file = str_replace("/", DIRECTORY_SEPARATOR, $asset_file);
        }

        return file_get_contents(
            dirname(__DIR__) . DIRECTORY_SEPARATOR .
                'src' . DIRECTORY_SEPARATOR .
                'templates' . DIRECTORY_SEPARATOR .
                'assets' . DIRECTORY_SEPARATOR .
                $asset_file
        );
    } */

    /* public static function loadAsset(string $asset_file): mixed
    {
        if (str_contains("/", $asset_file)) {
            $asset_file = str_replace("/", DIRECTORY_SEPARATOR, $asset_file);
        }

        return dirname(__DIR__) . DIRECTORY_SEPARATOR .
            'src' . DIRECTORY_SEPARATOR .
            'templates' . DIRECTORY_SEPARATOR .
            'assets' . DIRECTORY_SEPARATOR .
            $asset_file;
    } */

    public static function redirect(string $router): string
    {
        if (str_contains($router, "/")) {
            $router = str_replace("/", "", $router);
        }

        $http = 'http://';

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            $http = 'https://';
        }

        #$url = $http .  $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . $router;
        #$url = $http .  $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . $router;
        $url = $http . $_SERVER['HTTP_HOST'] . "/" . $router;

        if (str_contains($url, "index.php")) {
            $url = str_replace("index.php", "", $url);
        }

        return $url;
    }

    private static function passwordIsHash(mixed $password)
    {
        if (is_string($password)) {
            return password_get_info($password)['algoName'] !== 'unknown';
        }

        return false;
    }

    private static function getUri(): array
    {
        $uri = explode('/', $_SERVER['REQUEST_URI']);
        array_shift($uri);
        //$uri = "/" . end($uri);

        //dd($uri);

        return $uri;
    }

    public static function getAsset(string $asset): string
    {
        return '//' . $_SERVER['HTTP_HOST'] . "/src/templates/assets/" . $asset;
    }
}
