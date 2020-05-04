<?php require_once '../views/layouts/header.php';
Utils::comprobarGanador();
Utils::redirigir('tablero', 'jugadores.php');
$tablero = $_SESSION['tablero'];
?>
<h1 id='mensaje-principal'>Tablero de juego</h1>
<div class="contenedor">
    <div class="contenedor-seccion">
        <div class="informacion-partida">
            <h2>Este turno reparte: <?= $tablero->repartidorTurno() ?></h2>
            <h3>Turno: <?= $tablero->getTurno() ?></h3>
        </div>
    </div>

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
                <th>Puntos restantes</th>
                <th>Número de voladas</th>
                <th>Deuda acumulada</th>
            </tr>
            <?php foreach ($tablero->getJugadores() as $indice => $jugador) : ?>
                <tr>
                    <td><?= $jugador->getNombre() ?></td>
                    <td><?= $jugador->getPuntaje() ?></td>
                    <td><?= $jugador->getPuntosRestantes() ?></td>
                    <td><?= $jugador->getVoladas() ?></td>
                    <td><?= $jugador->calcularDeuda($_SESSION['volada'], $_SESSION['entrada']) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>

    <div class="botones">
        <a id='historico' class="boton" href="jugadores.php?update=1">Añadir jugador</a>
        <a id='fin-turno' class="boton" href="finTurno.php">Fin de turno</a>
    </div>

</div>

<?php require_once '../views/layouts/footer.php' ?>