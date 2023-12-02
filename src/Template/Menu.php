<?php

namespace Dashboard\Template;

use Dashboard\HelpersTrait;
use URLify;

class Menu
{
    use HelpersTrait;

    private array $item;
    private string $html;

    public function __construct()
    {
        $this->html = '<ul class="menu-inner py-1">' . "\n";
    }

    public function item(string $name)
    {
        if ($name instanceof TemplateInterface) {
            throw new TemplateException($name . " is not instance of 'AbstractTemplate' class");
        }

        $property = new \ReflectionProperty($name, 'url');
        $url = str_replace("/", "", $property->getDefaultValue());

        $class = new \ReflectionClass($name);
        $menu_name = $class->getShortName();

        $key_name = URLify::slug($class->getShortName());

        if ($class->hasProperty('menu_name')) {
            $class_menu_name = new \ReflectionProperty($name, 'menu_name');
            $menu_name = $class_menu_name->getDefaultValue();
        }

        $this->item[$key_name] = [
            'main-class' => $class->getName(),
            'url' => $url,
            'menu-name' => $menu_name
        ];

        return $this;
    }

    public function submenu(string $name, array $itens)
    {
        $all_itens = [];

        foreach ($itens as $itens) {
            $item_property = new \ReflectionProperty($itens, 'url');
            $url = str_replace("/", "", $item_property->getDefaultValue());

            $item_class = new \ReflectionClass($itens);
            $menu_child_name = $item_class->getShortName();

            if ($item_class->hasProperty('menu_name')) {
                $class_menu_name = new \ReflectionProperty($itens, 'menu_name');
                $menu_child_name = $class_menu_name->getDefaultValue();
            }

            $all_itens[] = [
                'main-class' => $name,
                'child-class' => $item_class->getName(),
                'url' => $url,
                'menu-name' => $name,
                'menu-child-name' => $menu_child_name
            ];
        }

        $this->item[$name] = $all_itens;
        return $this;
    }

    public function getMenuItens()
    {
        return $this->item;
    }

    public function create()
    {
        foreach ($this->item as $key => $link) {
            if (array_key_exists('url', $link)) {
                $this->html .= Template::getTemplate('menu/menu.php', [
                    'link' => Template::redirect($link['url']),
                    'menu_name' => $link['menu-name']
                ]);
            } else {
                $this->html .= Template::getTemplate('menu/menu-item.php', [
                    'menu_name' => $link[0]['menu-name']
                ]);

                foreach ($link as $link) {
                    $this->html .= Template::getTemplate('menu/menu-child.php', [
                        'link' => Template::redirect($link['url']),
                        'menu_name' => $link['menu-child-name']
                    ]);
                }
            }
        }

        return $this->html;
    }
}
