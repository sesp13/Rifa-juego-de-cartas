<?php require_once '../views/layouts/header.php';
Utils::redirigir('tablero', 'jugadores.php');
$tablero = $_SESSION['tablero']; ?>
<h1 id="mensaje-principal">Cambiar orden de jugadores</h1>
<div class="contenedor">
    <div class="form-container">
        <h2>Elige un nuevo orden</h2>
        <p class="mensaje">Asigna a la posición el nombre del jugador que desees, recuerda que 1 nombre solo puede estar en 1 posición</p>
        <?php require_once 'logic/cambiarOrden.php' ?>
        <form method="POST">
            <?php if (isset($_SESSION['error'])) : ?>
                <div class="contenedor-seccion" id='volados'>
                    <p class='mensaje-eliminado'><?= $_SESSION['error'] ?></p>
                </div>
            <?php endif; ?>
            <?php Utils::deleteSession('error'); ?>
            <?php foreach ($tablero->getJugadores() as $indice => $jugador) : ?>
                <div class="form-control">
                    <label>Posición <?= $indice + 1 ?></label>
                    <select name="pos-<?= $indice ?>" id="pos-<?= $indice ?>">
                        <?php foreach ($tablero->getJugadores() as $i => $x) : ?>
                            <option value="<?= $i ?>" <?= $i == $indice ? 'selected' : '' ?>><?= $x->getNombre() ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endforeach; ?>

            <input type="submit" name="enviar-cambio" class="boton" value="Enviar">
        </form>
    </div>
    <a class="boton" href="juego.php">Al tablero</a>
</div>
<?php require_once '../views/layouts/footer.php' ?>