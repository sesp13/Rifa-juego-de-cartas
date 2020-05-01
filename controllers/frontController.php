<?php

require_once 'classes/jugador.php';
require_once 'classes/tablero.php';

class frontController
{
    public static function enviarJuego()
    {
        if (isset($_POST['enviar'])) {
            $jugadores = isset($_POST['jugadores']) ? $_POST['jugadores'] : false;
            $volada = isset($_POST['volada']) ? $_POST['volada'] : false;
            $entrada = isset($_POST['entrada']) ? $_POST['entrada'] : false;

            //Validaciones numéricas
            if (!is_numeric($jugadores)) {
                $jugadores = false;
            }
            if (!is_numeric($volada)) {
                $volada = false;
            }
            if (!is_numeric($entrada)) {
                $entrada = false;
            }

            if ($jugadores && $volada && $entrada) {
                $_SESSION['cantidad'] = intval($jugadores);
                $_SESSION['volada'] = intval($volada);
                $_SESSION['entrada'] = intval($entrada);

                header('Location:jugadores.php');
            } else {
                $_SESSION['error'] = 'Error insertando los datos, inténtalo de nuevo';
            }
        }
    }

    public static function comprobarSeteoJuego()
    {
        if (!isset($_SESSION['cantidad']) || !isset($_SESSION['volada']) || !isset($_SESSION['entrada'])) {
            $_SESSION['error'] = 'Se ha producido un error con los datos enviados, por favor envialos de nuevo';
            header('Location:index.php');
        }
    }

    public static function programarTablero()
    {
        if (isset($_POST['enviar'])) {
            $cantidad = $_SESSION['cantidad'];
            $jugadores = array();
            for ($i = 1; $i < $cantidad + 1; $i++) {
                if ($_POST["jugador-$i"] != '') {
                    $jugadores[] = new Jugador($_POST["jugador-$i"]);
                } else {
                    return $_SESSION['error'] = 'Error al dar nombres, estos no pueden estar vacios';
                }
            }

            //Programar el tablero
            $entrada = $_SESSION['entrada'];
            $volada = $_SESSION['volada'];

            $tablero = new Tablero($entrada,$volada,$jugadores);
            $_SESSION['tablero'] = $tablero;

            header("Location:juego.php");
        }
    }
}
