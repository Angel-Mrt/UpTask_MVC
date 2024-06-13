<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        iniciarSesion();
        isAuth();
        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietario_id', $id);

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }
    public static function crear_proyecto(Router $router)
    {
        iniciarSesion();
        isAuth();
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);

            //validacion
            $alertas = $proyecto->validarProyecto();

            if (empty($alertas)) {
                //Generar una url unica
                $hash = md5(uniqid());
                $proyecto->url = $hash;
                //Almacenar el creador del proyecto
                $proyecto->propietario_id = $_SESSION['id'];
                //Guardar el Proyecto
                $proyecto->guardar();
                //Redireccionar 
                header('Location: /proyecto?id=' . $proyecto->url);
            }
        }
        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }

    public static function proyecto(Router $router)
    {
        iniciarSesion();
        isAuth();
        $token = $_GET['id'];
        if (!$token) header('Location: /dashboard');
        // Revisar que la persona que visita el proyecto, es quien la creo
        $proyecto = Proyecto::where('url', $token);
        if ($proyecto->propietario_id !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto
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
