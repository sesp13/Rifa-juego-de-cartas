<?php require_once '../views/layouts/header.php';
Utils::comprobarGanador();
Utils::redirigir('tablero', 'jugadores.php');
if(isset($_SESSION['historico'])){
    header('Location:index.php');
}
$tablero = $_SESSION['tablero'];
?>
<h1 id='mensaje-principal'>Tablero de juego</h1>
<div class="contenedor">
    <div class="contenedor-seccion">
        <div class="informacion-partida">
            <h2>Este turno reparte: <span><?= $tablero->repartidorTurno() ?></span></h2>
            <h3>Turno: <?= $tablero->getTurno() ?></h3>
        </div>
    </div>

    <?php if (isset($_SESSION['error'])) : ?>
        <div class="contenedor-seccion" id='volados'>
            <p class='mensaje-eliminado'><?= $_SESSION['error'] ?></p>
        </div>
    <?php endif; ?>
    <?php Utils::deleteSession('error'); ?>

    <?php if (isset($_SESSION['volados']) && !empty($_SESSION['volados'])) : ?>
        <div class="contenedor-seccion" id='volados'>
            <?php foreach ($_SESSION['volados'] as $volado) : ?>
                <p class="mensaje-eliminado">El jugador <?= $volado->getNombre() ?> ha volado</p>
            <?php endforeach; ?>
        </div>
        <?php Utils::deleteSession('volados') ?>
    <?php endif; ?>

    <div class="contenedor-seccion">
        <table>
            <tr id='inicial'>
                <th>Nombre</th>
                <th>Puntaje</th>
                <th>Vuela con</th>
                <th>Número de voladas</th>
                <th>Deuda acumulada</th>
            </tr>
            <?php foreach ($tablero->getJugadores() as $indice => $jugador) : ?>
                <tr>
                    <td><?= $jugador->getNombre() ?></td>
                    <td><?= $jugador->getPuntaje() ?></td>
                    <td><?= $jugador->getPuntosRestantes() ?></td>
                    <td><?= $jugador->getVoladas() ?></td>
                    <td><?= $jugador->calcularDeuda($tablero->getValorEntrada(), $tablero->getValorVolada()) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
        <?php if ($tablero->getValorActual() > 0) : ?>
            <h4>Deuda de los jugadores eliminados : $ <?= $tablero->getValorActual() ?></h4>
        <?php endif; ?>
    </div>
    
    <div class="botones f-none-right">
        <div class="boton-div">
            <a class="boton f-none-right" href="finTurno.php">Fin de turno</a>
        </div>
    </div>

    <div class="botones f-none-left">
        <div class="boton-div">
            <a class="boton" href="jugadores.php?update=1">Añadir jugador</a>
            <a class="boton" id='eliminar-jugador'>Eliminar jugador</a>
        </div>
        <div id='formulario-eliminar'>
            <?php require_once 'logic/eliminarJugador.php' ?>
            <form method="POST">
                <h3>Eliminar un jugador</h3>
                <div class="form-control">
                    <label>Escoge un jugador para eliminar</label>
                    <select name="jugador">
                        <?php foreach ($tablero->getJugadores() as $indice => $jugador) : ?>
                            <option value="<?= $indice ?>"> <?= $jugador->getNombre() ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" name="eliminar-jugador" class="boton" value="Eliminar">
            </form>
        </div>
        <button class="boton w-100-big" id='mostrarOtros'>Otras acciones</button>
        <div id="otros-botones">
            <div class="boton-div">
                <a class="boton w-100-big" href="historico.php">Histórico de juegos</a>
                <a class="boton w-100-big" href="finTurno.php?editar=1">Editar último turno</a>
            </div>
        </div>
    </div>


</div>
<?php require_once '../views/layouts/footer.php' ?>
<!-- archivos de js -->
<script src="../js/juego.js"></script>