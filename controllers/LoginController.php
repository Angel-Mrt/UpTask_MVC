<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
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
        $alertas = [];
        $usuario = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            if (empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);

                if ($existeUsuario) {
                    Usuario::setAlerta('error', 'El Usuario Ya esta Registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear Password
                    $usuario->hashPassword();
                    //Eliminar password2
                    unset($usuario->password2);
                    //Crear token
                    $usuario->crearToken();
                    // Crear un Nuevo Usuario
                    $resultado = $usuario->guardar();
                    //Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();



                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        // render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crear Usuario',
            'usuario' => $usuario,
            'alertas' => $alertas
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

    public static function mensaje(Router $router)
    {

        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
    }

    public static function confirmar(Router $router)
    {
        $token = s($_GET['token']);
        if (!$token) header('Location: /');

        // Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // No se encontro un usuario con ese token
            Usuario::setAlerta('error', 'Token No Valido');
        } else {
            // Confirmar la Cuenta
            $usuario->confirmado = 1;
            $usuario->token = "";
            unset($usuario->password2);
            // Guardar en la BD
            $usuario->guardar();

            Usuario::setAlerta('exito', 'Cuenta Confirmada Exitosamenete');
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar', [
            "titulo" => 'Cuenta Confirmada',
            'alertas' => $alertas
        ]);
    }
}
