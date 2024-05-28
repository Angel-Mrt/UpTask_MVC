<?php

namespace Controllers;

use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }


        // render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesion'
        ]);
    }

    public static function logout()
    {
        echo 'desde login';
    }

    public static function crear(Router $router)
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        // render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crear Usuario'
        ]);
    }

    public static function olvide(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }

        $router->render('auth/olvide', [
            'titulo' => 'Olvide mi password'
        ]);
    }

    public static function reestablecer(Router $router)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        }
        // render a la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password'
        ]);
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
