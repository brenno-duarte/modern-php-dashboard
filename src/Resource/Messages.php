<?php

namespace Dashboard\Resource;

class Messages
{
    public static function get(string $index)
    {
        try {
            if(isset($_SESSION[$index])){
                return $_SESSION[$index];
            }
        } finally {
            if(isset($_SESSION[$index])){
                unset($_SESSION[$index]);
            }
        }
    }

    public static function add(string $index, string $message, string $css_class = "success"): void
    {
        $message = self::htmlMessage($message, $css_class);
        $_SESSION[$index] = $message;
    }

    /* public static function edit(string $message = "Resource edited", string $css_class = "success"): void
    {
        $message = self::htmlMessage($message, $css_class);
        $_SESSION['edit'] = $message;
    }

    public static function delete(string $message = "Resource deleted", string $css_class = "success"): void
    {
        $message = self::htmlMessage($message, $css_class);
        $_SESSION['delete'] = $message;
    } */

    private static function htmlMessage(string $message, string $css_class): string
    {
        $default_html = '<div class="alert alert-'. $css_class .' alert-dismissible fade show" role="alert">
            ' . $message . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

        return $default_html;
    }
}
