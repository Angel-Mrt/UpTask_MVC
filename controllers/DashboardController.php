<?php

namespace Controllers;

use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        iniciarSesion();
        isAuth();
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos'
        ]);
    }
    public static function crear_proyecto(Router $router)
    {
        iniciarSesion();
        isAuth();
        $alertas = [];
        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }
    public static function perfil(Router $router)
    {
        iniciarSesion();
        isAuth();
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil'
        ]);
    }
}
