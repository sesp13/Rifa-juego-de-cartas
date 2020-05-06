<?php

if (isset($_POST['eliminar-jugador'])) {
    $tablero = $_SESSION['tablero'];
    $id = isset($_POST['jugador']) ? intval($_POST['jugador']) : null;
    //Que sea un número el id
    $id = is_numeric($id) ? intval($_POST['jugador']) : null;
    if (isset($id)) {
        $tablero->eliminarJugador($id);
        $_SESSION['tablero'] = $tablero;
        header('Location:juego.php');
    } else {
        header('Location:juego.php');
    }
}
