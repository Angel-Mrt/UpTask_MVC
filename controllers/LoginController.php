<?php

namespace Controllers;

class LoginController
{
    public static function login()
    {
        echo 'desde login';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    public static function logout()
    {
        echo 'desde login';
    }

    public static function crear()
    {
        echo 'desde crear cuenta';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }
}
