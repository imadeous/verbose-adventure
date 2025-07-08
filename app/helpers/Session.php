<?php

use Core\Session;

if (!function_exists('session')) {
    /**
     * Get the session instance.
     *
     * @return \Core\Session
     */
    function session()
    {
        return new Session();
    }
}
