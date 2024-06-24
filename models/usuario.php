<?php

namespace Model;

use Model\ActiveRecord;

class Usuario extends ActiveRecord
{
    protected static $tabla = 'usuarios';
    protected static $columnasDB = [
        'id', 'nombre', 'email',  'password',
        'token', 'confirmado'
    ];
    public $id;
    public $nombre;
    public $email;
    public $password;
    public $password2;
    public $token;
    public $confirmado;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? null;
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;
    }
    //Validar el login de usuario
    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email No Válido';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password del Usuario es Obligatorio';
        }
        return self::$alertas;
    }
    //Validar cuentas nuevas
    public function validarNuevaCuenta()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Usuario es Obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener almenos 6 caracteres';
        }
        if ($this->password  !== $this->password2) {
            self::$alertas['error'][] = 'Los Passwords no son iguales';
        }

        return self::$alertas;
    }

    //Valida los emails
    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email No Válido';
        }
        return self::$alertas;
    }
    // Valida el Password
    public function validarPassword()
    {

        if (!$this->password) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener almenos 6 caracteres';
        }
        if ($this->password  !== $this->password2) {
            self::$alertas['error'][] = 'Los Passwords no son iguales';
        }

        return self::$alertas;
    }

    //Hashea el Password
    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    //Generar un token
    public function crearToken()
    {
        $this->token = uniqid();
        //$this->token = md5(uniqid());
    }
    public function comprobarPasswordAndVerificado($password)
    {
        //debuguear($password);
        $resultado = password_verify($password, $this->password);
        //debuguear($resultado);
        if (!$this->confirmado) {
            self::$alertas['error'][] = 'Cuenta no confirmada';
        } else if (!$resultado) {
            self::$alertas['error'][] = 'Contraseña Incorrecta';
        } else {
            return true;
        }
    }
}
