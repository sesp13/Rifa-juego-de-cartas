<?php
require_once 'views/layouts/header.php';
require_once 'controllers/frontController.php';
frontController::comprobarSeteoJuego();
frontController::programarTablero();
$cantidad = $_SESSION['cantidad'];
?>
<h1 id='mensaje-principal'>Nombrar jugadores</h1>
<div class="contenedor">
    <h2>Dale un nombre a los héroes que batallaran este juego</h2>
    <div class="form-container">
        <form action='jugadores.php' method="POST">
            <?php if (isset($_SESSION['error'])) : ?>
                <p class='mensaje'><?= $_SESSION['error'] ?></p>
            <?php endif; ?>
            <?php Utils::deleteSession('error'); ?>            
            <?php for ($i = 1; $i < $cantidad + 1; $i++) : ?>
                <div class="form-control">
                    <label>Nombre del jugador <?=$i?></label>
                    <input type="text" name="jugador-<?=$i?>" placeholder="jugador <?=$i?>">
                </div>
            <?php endfor; ?>
            <input type="submit" name="enviar" class="boton" value="Enviar">
        </form>
    </div>
</div>
<?php require_once 'views/layouts/footer.php' ?>