<?php require_once '../views/layouts/header.php';
Utils::redirigir('tablero', 'index.php');
$tablero = $_SESSION['tablero'];
$historico = $tablero->getHistorico();
?>
<h1 id='mensaje-principal'>Histórico de juegos</h1>
<div class="contenedor">
    <?php if (count($historico) > 0) :
        foreach ($historico as $elemento) :
    ?>
            <div class="contenedor-seccion">
                <table>
                    <caption>Turno: <?= $elemento['turno'] ?></caption>
                    <tr id='inicial'>
                        <th>Jugador</th>
                        <th>Puntaje</th>
                        <th>Voladas</th>
                    </tr>
                    <?php foreach ($elemento['jugadores'] as $jugador) : ?>
                        <tr>
                            <td><?= $jugador['nombre'] ?></td>
                            <td><?= !$jugador['vuelo'] ? $jugador['puntaje'] : 'Voló en el turno' ?></td>
                            <td><?= $jugador['voladas'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endforeach;
    else : ?>
        <h2>Sin datos! no se han jugado turnos por el momento</h2>
    <?php endif; ?>
    <?php if (isset($_SESSION['historico'])) : ?>
        <a class="boton" href="index.php">Volver al menú principal</a>
        <a class="boton" href="ganador.php?id=<?=$_SESSION['idGanador']?>">Volver a la página del ganador</a>
    <?php else : ?>
        <a class="boton" href="juego.php">Al tablero</a>
    <?php endif ?>
</div>
<?php require_once '../views/layouts/footer.php' ?>