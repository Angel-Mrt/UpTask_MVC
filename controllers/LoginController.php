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

    public static function olvide()
    {
        echo 'desde olvide cuenta';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    public static function reestablecer()
    {
        echo 'desde reestablecer cuenta';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
    }

    public static function mensaje()
    {
        echo 'desde mensaje cuenta';
    }

    public static function confirmar()
    {
        echo 'desde confirmacion cuenta';
    }
}
