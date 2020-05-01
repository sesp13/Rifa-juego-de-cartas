<?php

class Utils
{

    public static function deleteSession($nombre)
    {
        if (isset($_SESSION[$nombre])) {
            unset($_SESSION[$nombre]);
        }
    }

    public static function redirigir($nombre, $pagina)
    {
        if (!isset($_SESSION[$nombre])) {
            $_SESSION['error'] = 'Se ha producido un error con la carga de la página';
            header("Locarion:$pagina");
        }
    }
}
