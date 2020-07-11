<?php require_once '../views/layouts/header.php';
Utils::redirigir('tablero', 'jugadores.php');
$tablero = $_SESSION['tablero']; ?>
<h1 id="mensaje-principal">Elegir repartidor</h1>
<div class="contenedor">
    <div class="form-container">
        <h2>Elige un nuevo repartidor</h2>
        <?php require_once 'logic/nuevoRepartidor.php' ?>
        <form method="POST">
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="contenedor-seccion" id='volados'>
                    <p class='mensaje-eliminado'><?= $_SESSION['error'] ?></p>
                </div>
            <?php endif; ?>
            <?php Utils::deleteSession('error'); ?>
            <div class="form-control">
                <select name="jugador-seleccionado" id="jugador-seleccionado">
                    <?php foreach ($tablero->getJugadores() as $indice => $jugador) : ?>
                        <option value="<?= $indice ?>"><?= $jugador->getNombre() ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="submit" name="nuevo-repartidor" class="boton" value="Cambiar">
        </form>
    </div>
    <a class="boton" href="juego.php">Al tablero</a>
</div>
<?php require_once '../views/layouts/footer.php' ?>