<?php
require_once '../views/layouts/header.php';
require_once '../controllers/frontController.php';
Utils::deleteSession('ganador');
Utils::redirigir('tablero', 'index.php');
Utils::redirigir('id', 'juego.php', true);
$tablero = $_SESSION['tablero'];
$id = $_GET['id'];
$ganador = $tablero->getJugadores()[$id];
$perdedores = $tablero->getPerdedores($id);
$eliminados = $tablero->getEliminados();
$deudaTotal = 0;
// $cantidad = $_SESSION['cantidad'];
?>
<h1 id='mensaje-principal'>Fin de juego: <?= $ganador->getNombre() ?> ha ganado</h1>
<div class="contenedor">
    <h2>Datos del juego</h2>

    <div class="datos-juego">
        <h3 class="entrada">Valor de la entrada: $ <?= $_SESSION['entrada'] ?></h3>
        <h3 class="volada">Valor de la volada : $ <?= $_SESSION['volada'] ?></h3>
        <h3 class="volada">Juego a: <?= $_SESSION['tope'] ?> puntos</h3>
        <?php if ($tablero->getValorActual() > 0) : ?>
            <h3 class="volada">Deuda de jugadores eliminados: $ <?= $tablero->getValorActual() ?></h3>
        <?php endif; ?>
    </div>
    <div class="contenedor-turno-final">
        <h3 class="turnos-final">Total de turnos: <?= $tablero->getTurno() - 1 ?></h3>
    </div>
    <div class="contenedor-seccion">
        <!-- <h3></h3> -->
        <table>
            <caption>Información de los perdedores</caption>
            <tr id='inicial'>
                <th>Nombre</th>
                <th>Deuda</th>
                <th>Número de voladas</th>
            </tr>
            <?php
            foreach ($perdedores as $perdedor) :
                $deuda = $perdedor->calcularDeuda($tablero->getValorEntrada(), $tablero->getValorVolada());
                $deudaTotal += $deuda;
            ?>
                <tr>
                    <td><?= $perdedor->getNombre() ?> </td>
                    <td class='moneda'>$ <?= $deuda ?></td>
                    <td><?= $perdedor->getVoladas() ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($eliminados) > 0) :
                foreach ($eliminados as $jugador) : ?>
                <tr>
                    <td class="nombre-eliminado"><?= $jugador['nombre'] ?> (Eliminado)</td>
                    <td class="moneda">$ <?= $jugador['deuda'] ?> </td>
                    <td><?= $jugador['voladas'] ?> </td>
                </tr>                    
            <?php endforeach;
            endif; ?>
        </table>
    </div>

    <h2> Datos del ganador </h2>
    <div class="datos-ganador">
        <p class="mensaje">Felicidades guerrero <?= $ganador->getNombre() ?> por tu gran batalla!</p>
        <p class="mensaje">
            Volaste: <?php echo $ganador->getVoladas() . ' ';
                        echo $ganador->getVoladas() == 1 ? 'vez' : 'veces'; ?> pero no importa valió la pena
        </p>
        <p class="mensaje">En total ahorraste: $ <?= $ganador->calcularDeuda($tablero->getValorEntrada(), $tablero->getValorVolada()) ?></p>
        <p class="mensaje">En total ganaste: $ <?= $deudaTotal + $tablero->getValorActual() ?></p>
        <a class="boton" href="historico.php">Ver el histórico de juegos</a>
    </div>

    <div class="boton-final-div">
        <a class="boton boton-final" href="index.php">Volver al menú principal</a>
    </div>
    <?php
    //Sesión del histórico final
    $historico = $_SESSION['tablero']->getHistorico();
    $_SESSION['historico'] = $historico;
    $_SESSION['idGanador'] = $id;
    ?>
</div>
<?php require_once '../views/layouts/footer.php' ?>