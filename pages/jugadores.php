<?php
require_once '../views/layouts/header.php';
require_once '../controllers/frontController.php';
if (isset($_SESSION['historico'])) {
    header('Location:index.php');
}
// Utils::redirigir('cantidad', 'index.php');
$actualizar = isset($_GET['update']) ? true : false;
if ($actualizar) {
    frontController::agregarJugador();
} else {
    frontController::comprobarSeteoJuego();
}
frontController::programarTablero();
$cantidad = $actualizar ? 1 : $_SESSION['cantidad'];
?>
<h1 id='mensaje-principal'><?= $actualizar ? 'Nuevo jugador' : 'Nombrar jugadores' ?></h1>
<div class="contenedor">
    <?php if ($actualizar) : ?>
        <h2>Dale un nombre al nuevo guerrero que se unirá a este combate feroz</h2>
    <?php else : ?>
        <h2>Dale un nombre a los héroes que batallaran este juego</h2>
    <?php endif; ?>
    <div class="form-container">
        <form method="POST">
            <?php if (isset($_SESSION['error'])) : ?>
                <p class='mensaje'><?= $_SESSION['error'] ?></p>
            <?php endif; ?>
            <?php Utils::deleteSession('error'); ?>
            <?php if ($actualizar) : ?>
                <div class="form-control">
                    <label> Nombre del nuevo jugador: </label>
                    <input type="text" name="jugador-nuevo" placeholder="Nombre">
                </div>
            <?php else : ?>
                <?php for ($i = 1; $i < $cantidad + 1; $i++) : ?>
                    <div class="form-control">
                        <label> <?= "Nombre del jugador $i" ?></label>
                        <input type="text" name="jugador-<?= $i ?>" placeholder="jugador <?= $i ?>">
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
            <input type="submit" name="enviar" class="boton" value="Enviar">
        </form>
    </div>
    <?php if ($actualizar) : ?>
        <a class="boton" href="juego.php">Al tablero</a>
    <?php endif ?>
</div>
<?php require_once '../views/layouts/footer.php' ?>