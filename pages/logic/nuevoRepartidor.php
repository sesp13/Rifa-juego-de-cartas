<?php
if (isset($_POST['nuevo-repartidor'])) {
    $index = $_POST['jugador-seleccionado'];
    $tablero->nuevoRepartidor($index);
}
