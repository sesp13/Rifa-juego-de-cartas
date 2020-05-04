<?php

require_once '../classes/jugador.php';
require_once '../classes/tablero.php';

class frontController
{
    public static function enviarJuego()
    {
        if (isset($_POST['enviar'])) {
            $jugadores = isset($_POST['jugadores']) ? $_POST['jugadores'] : false;
            $volada = isset($_POST['volada']) ? $_POST['volada'] : false;
            $entrada = isset($_POST['entrada']) ? $_POST['entrada'] : false;
            $tope = isset($_POST['tope']) ? $_POST['tope'] : false;

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
            if (!is_numeric($tope)) {
                $tope = false;
            }

            if ($jugadores && $volada && $entrada && $tope) {
                $_SESSION['cantidad'] = intval($jugadores);
                $_SESSION['volada'] = intval($volada);
                $_SESSION['entrada'] = intval($entrada);
                $_SESSION['tope'] = intval($tope);

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
                    $jugadores[] = new Jugador($_POST["jugador-$i"], $_SESSION['tope']);
                } else {
                    return $_SESSION['error'] = 'Error al dar nombres, estos no pueden estar vacios';
                }
            }

            //Programar el tablero
            $entrada = $_SESSION['entrada'];
            $volada = $_SESSION['volada'];
            $tope = $_SESSION['tope'];

            $tablero = new Tablero($entrada, $volada, $jugadores);
            $_SESSION['tablero'] = $tablero;

            header("Location:juego.php");
        }
    }

    public static function agregarJugador()
    {
        if (isset($_POST['enviar']) && isset($_SESSION['tablero']) && isset($_GET['update'])) {
            // echo 'Estoy aquí <br>';
            // die();
            $cantidad = $_SESSION['cantidad'];
            $tablero = $_SESSION['tablero'];
            $jugadores = $tablero->getJugadores();
            $nombre = $_POST['jugador-nuevo'] != '' ? $_POST['jugador-nuevo'] : false;
            if ($nombre) {
                echo 'Estoy aquí también <br>';
                $puntajeMaximo = $tablero->getDatosFinales(true);
                $jugador = new Jugador($nombre, $_SESSION['tope']);
                $jugador->setPuntaje($puntajeMaximo);
                array_push($jugadores, $jugador);
                $tablero->setJugadores($jugadores);

                //Actualizar la sesión
                $_SESSION['cantidad'] = $cantidad + 1;
                $_SESSION['tablero'];

                // echo 'me voy a enviar<br>';
                // die();
                header('Location:juego.php');
            } else {
                $_SESSION['error'] = 'Error: No puedes dejar el nombre del nuevo jugador vacío';
            }
        }
    }
}
