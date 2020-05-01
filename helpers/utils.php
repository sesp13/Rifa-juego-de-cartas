<?php

class Utils
{

    public static function deleteSession($nombre)
    {
        if (isset($_SESSION[$nombre])) {
            unset($_SESSION[$nombre]);
        }
    }

    public static function redirigir($nombre, $pagina, $get = null)
    {
        if (isset($get)) {
            if (!isset($_GET[$nombre])) {
                header("Location:$pagina");
            }
        } else {
            if (!isset($_SESSION[$nombre])) {
                $_SESSION['error'] = 'Se ha producido un error con la carga de la página';
                header("Location:$pagina");
            }
        }
    }

    public static function comprobarGanador(){
        if(isset($_SESSION['ganador'])){
            header("Location:ganador.php?id={$_SESSION['ganador']}");
        }
    }
}
