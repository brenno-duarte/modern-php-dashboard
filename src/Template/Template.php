<?php

namespace Dashboard\Template;

session_start();

use Dashboard\Auth\Login;
use Dashboard\Change;
use Dashboard\HelpersTrait;
use Dashboard\Router;

class Template
{
    use HelpersTrait;

    //private ?Login $login = null;
    private static ?string $type = null;
    private static string $html;
    private array $default_class = [
        Login::class,
        Change::class
    ];

    public function __construct(
        private Login $login = new Login()
    )
    {
        
    }

    private function handleCRUD(array $routers, string $uri)
    {
        if (!empty($routers)) {
            foreach ($routers as $router) {
                $class = new $router;
                $get_property_router = new \ReflectionProperty($class, 'url');
                $url = $get_property_router->getValue($class);
                $url = str_replace("/", "", $url);

                if ($url == $uri) {
                    if (!empty($_POST)) {
                        $class->handle();
                        exit;
                    }
                }
            }
        }
    }

    private static function handleRouteResource(string $instance)
    {
        $class = new $instance;

        if (self::$type == "create") {
            $class->create();
        } elseif (self::$type == "edit") {
            $class->edit(self::getUri()[2]);
        }  elseif (self::$type == "delete") {
            $class->delete(self::getUri()[2]);
        } else {
            $class->generate();
        }
    }

    public static function route(string $type): string
    {
        self::$type = $type;
        $uri = self::getUri();
        return $uri[0] . "/" . $type;
    }

    private function validateRouteType(): ?string
    {
        $uri = self::getUri();

        if (isset($uri[1])) {
            self::$type = $uri[1];
        }
        
        return self::$type;
    }

    public function render(object $html)
    {
        $this->verifyInternalTemplateByDefaultClass();

        $reflection = new \ReflectionProperty($html, 'html');
        $reflection_menu = new \ReflectionMethod($html, 'getMenuItens');
        $res = $reflection_menu->invoke($html);

        $uri = self::getUri();
        $routers = Router::getRouters();

        $this->handleCRUD($routers, $uri[0]);

        foreach ($res as $key) {
            if (array_key_exists('url', $key)) {
                $url_array = str_replace("/", "", $key['url']);

                if ($url_array == $uri[0]) {
                    $this->generateFullTemplate(
                        $key['menu-name'],
                        $reflection->getValue($html),
                        $key['main-class']
                    );
                }
            } else {
                foreach ($key as $value) {
                    $url_array = str_replace("/", "", $value['url']);

                    if ($url_array == $uri[0]) {
                        $this->generateFullTemplate(
                            $value['menu-child-name'],
                            $reflection->getValue($html),
                            $value['child-class']
                        );
                    }
                }
            }
        }

        $this->notFound();
    }

    private static function handleTemplate(string $template): string
    {
        if (str_contains($template, "/")) {
            $template = str_replace("/", DIRECTORY_SEPARATOR, $template);
        }

        $file = dirname(__DIR__) .
            DIRECTORY_SEPARATOR . "templates" .
            DIRECTORY_SEPARATOR . $template;

        if (!file_exists($file)) {
            throw new TemplateException("Template " . $file . " not exists");
        }

        return $file;
    }

    public static function getTemplate(string $template, array $replace = []): string
    {
        $file = self::handleTemplate($template);
        $template = file_get_contents($file);

        if (!empty($replace)) {
            foreach ($replace as $key => $value) {
                if (str_contains($template, "{{" . $key . "}}")) {
                    $template = str_replace("{{" . $key . "}}", $value, $template);
                }
            }
        }

        return $template;
    }

    public static function renderTemplate(string $template, array $replace = []): string
    {
        ob_start();
        extract($replace);

        $file = self::handleTemplate($template);
        include_once $file;

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    private function verifyInternalTemplateByDefaultClass(): Template
    {
        $uri = self::getUri()[0];
        $uri_withour_parameter = strtok($uri, '?');
        $get_parameter = explode("?", $uri);

        foreach ($this->default_class as $value) {
            $class_name = (new \ReflectionClass($value))->getName();
            $url = (new \ReflectionProperty($value, 'url'))->getDefaultValue();
            $url = str_replace("/", "", $url);

            if ($url == $uri_withour_parameter) {
                $class = new $class_name;
                $class->generate($get_parameter);
                exit;
                //$this->includeTemplate("auth/" . strtolower(end($class_name)) . ".php");
            }
        }

        $this->validateRouteType();

        return $this;
    }

    private function includeTemplate(string $template_file, array $args = []): void
    {
        if (!empty($args)) {
            extract($args);
        }

        include_once dirname(__DIR__) .
            DIRECTORY_SEPARATOR . 'templates' .
            DIRECTORY_SEPARATOR . $template_file;
    }

    private function getAuthTemplate(string $auth_template): void
    {
        $this->includeTemplate("auth" . DIRECTORY_SEPARATOR . $auth_template, []);
    }

    private function notFound(): void
    {
        if (self::getUri()[0] == "") {
            $this->getAuthTemplate("login.php");
            exit;
        }

        $this->includeTemplate('404-not-found.php');
        exit;
    }

    private function generateFullTemplate(
        string $menu_name,
        string $menu_html,
        string $instance
    ): void {
        $this->login->isLogged();

        ob_start();
        echo $this->renderTemplate('init.php', [
            'title' => $menu_name
        ]);

        echo $this->renderTemplate('init-header.php');
        echo $menu_html;
        echo '<div class="card">
        <div class="card-body">' . "\n";

        echo $this->renderTemplate('close-header.php', [
            'menu_name' => $menu_name
        ]);

        $this->handleRouteResource($instance);
        echo $this->renderTemplate('close-init.php');

        exit;
    }
}
