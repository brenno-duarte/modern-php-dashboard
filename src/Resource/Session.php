<?php

namespace Dashboard\Resource;

/**
 * Class Session
 * @package App\Framework
 */
class Session
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * @param string|null $key
     * @return array|mixed|null
     */
    public function get(string $key = null)
    {
        if ($key) {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
            return null;
        }
        return $_SESSION;
    }

    /**
     * @param string $key
     * @param $value
     * @return bool
     */
    public function put(string $key, $value): bool
    {
        $_SESSION[$key] = $value;
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @return bool
     */
    public function destroy(): bool
    {
        return session_destroy();
    }

    /**
     * @return bool
     */
    public function unset(): bool
    {
        return session_unset();
    }

    /**
     * @param string $key
     * @return bool
     */
    public function forget(string $key): bool
    {
        try {
            unset($_SESSION[$key]);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
