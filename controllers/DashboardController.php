<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
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
        $alertas = [];
        $usuario = Usuario::find($_SESSION['id']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarPerfil();

            if (empty($alertas)) {
                //Verficar que eel email existe
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    //Mostrar mensaje de error
                    Usuario::setAlerta('error', 'El Email ya pertenece a otra cuenta');
                    $alertas = $usuario->getAlertas();
                } else {
                    // Guardar el registro
                    $usuario->guardar();
                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $usuario->getAlertas();
                    //Asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }
            }
            //debuguear($usuario);
        }
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function cambiar_password(Router $router)
    {
        iniciarSesion();
        isAuth();
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);
            // Sincronizar con los datos deñ usuario
            $usuario->sincronizar($_POST);
            $alertas = $usuario->nuevo_password();
            if (empty($alertas)) {
                $resultado = $usuario->comprobar_password();

                if ($resultado) {
                    //Asignar el nuevo Password
                    $usuario->password = $usuario->password_nuevo;

                    //Eliminar propiedades no necesarias
                    unset($usuario->password_nuevo);
                    unset($usuario->password_actual);
                    unset($usuario->password2);

                    //Hashear el nuevo password
                    $usuario->hashPassword();

                    //Actualizar
                    $resultado = $usuario->guardar();
                    if ($resultado) {
                        Usuario::setAlerta('exito', 'Password Actualizado Correctamente');
                    }
                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                }

                $alertas = $usuario->getAlertas();
                //debuguear('Paso la validacion');
            }
        }

        $router->render('dashboard/cambiar-password', [
            'titulo' =>  'Cambiar Password',
            'alertas' => $alertas

        ]);
    }
}
