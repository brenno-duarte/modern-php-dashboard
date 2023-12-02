<?php

use Dashboard\Resource\Session;

if (!function_exists('session')) {
    function session(): Session
    {
        return new Session;
    }
}
