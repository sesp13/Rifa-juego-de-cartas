<?php
require_once '../views/layouts/header.php';
//require_once 'controllers/frontController.php';
//frontController::comprobarSeteoJuego();
//frontController::programarTablero();
$tablero = $_SESSION['tablero'];
if (isset($_GET['editar'])) {
    $editar = true;
    $tablero->finalDeTurno(true);
    $turno = $tablero->getTurno() - 1;
} else {
    $editar = false;
    $tablero->finalDeTurno();
}
$cantidad = $_SESSION['cantidad'];
?>
<?php if (!(($tablero->getTurno() == 1) && $editar)) : ?>
    <h1 id='mensaje-principal'><?= $editar ? 'Editar último turno: ' . $turno : 'Final del turno' ?></h1>
    <div class="contenedor">
        <h2>Por favor inserta los puntajes de los jugadores para este turno</h2>
        <div class="form-container">
            <form method="POST" id='finTurno'>
                <?php if (isset($_SESSION['error'])) : ?>
                    <p class='mensaje'><?= $_SESSION['error'] ?></p>
                <?php endif; ?>
                <?php Utils::deleteSession('error'); ?>
                <?php foreach ($tablero->getJugadores() as $indice => $jugador) : ?>
                    <div class="form-control">
                        <label>Puntos de <?= $jugador->getNombre() ?></label>
                        <input type="number" name="jugador-<?= $indice ?>" value="<?= $editar ? $jugador->getPuntajeAdquirido() : '' ?>">
                    </div>
                <?php endforeach; ?>
                <input type="submit" name="enviar" class="boton" value="Enviar">
            </form>
            <a class="boton" href="juego.php">Al tablero</a>
        </div>
    </div>
<?php else : ?>
    <h1 id="mensaje-principal">Atención</h1>
    <div class="contenedor">
        <h2>No se han jugado turnos, no puedes editar</h2>
        <a class="boton" href="juego.php">Al tablero</a>
    </div>
<?php endif ?>
<?php require_once '../views/layouts/footer.php' ?>