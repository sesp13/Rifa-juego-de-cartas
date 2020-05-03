<?php
require_once 'views/layouts/header.php';
//require_once 'controllers/frontController.php';
//frontController::comprobarSeteoJuego();
//frontController::programarTablero();
$tablero = $_SESSION['tablero'];
$tablero->finalDeTurno();
$cantidad = $_SESSION['cantidad'];
?>
<h1 id='mensaje-principal'>Final del turno</h1>
<div class="contenedor">
    <h2>Por favor inserta los puntajes de los jugadores para este turno</h2>
    <div class="form-container">
        <form method="POST">
            <?php if (isset($_SESSION['error'])) : ?>
                <p class='mensaje'><?= $_SESSION['error'] ?></p>
            <?php endif; ?>
            <?php Utils::deleteSession('error'); ?>
            <?php foreach ($tablero->getJugadores() as $indice => $jugador) : ?>
                <div class="form-control">
                    <label>Puntos de <?= $jugador->getNombre() ?></label>
                    <input type="number" name="jugador-<?= $indice ?>">
                </div>
            <?php endforeach; ?>
            <input type="submit" name="enviar" class="boton" value="Enviar">
        </form>
    </div>
</div>
<?php require_once 'views/layouts/footer.php' ?>