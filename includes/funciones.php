<?php

function debuguear($variable): string
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

// Función que revisa que el usuario este autenticado
function isAuth(): void
{
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}
// Iniciar la sesion
function iniciarSesion()
{
    // Verifica si la sesión no está iniciada
    if (!isset($_SESSION)) {
        // Inicia la sesión
        session_start();
    }
}  
function mostrarNotificacion($resultado)
{
    $mensaje = '';

    switch ($resultado) {
        case 1:
            $mensaje = '¡¡Creado Correctamente!!';
            break;
        case 2:
            $mensaje = '¡¡Actualizado Correctamente!!';
            break;
        case 3:
            $mensaje = '¡¡Eliminado Correctamente!!';
            break;
        case 4:
            $mensaje = '¡¡No Se Pudo Eliminar!!';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}
