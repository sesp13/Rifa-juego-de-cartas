<?php
require_once '../views/layouts/header.php';
require_once '../controllers/frontController.php';
frontController::enviarJuego();
?>
<h1 id='mensaje-principal'>Bienvenido a la rifa</h1>
<div class="contenedor">
    <h2>Programar juego</h2>
    <p class="mensaje">Vamos a elegir las reglas para este juego</p>
    <div class="form-container">
        <form method="POST">
            <?php if (isset($_SESSION['error'])) : ?>
                <p class='mensaje'><?= $_SESSION['error'] ?></p>
            <?php endif; ?>
            <?php Utils::deleteSession('error'); ?>
            <div class="form-control">
                <label>¿Cuántos jugadores pariciparán en el juego?</label>
                <input type="number" name="jugadores" min='2' value="2" step="1">
            </div>
            <div class="form-control">
                <label>¿Cuál es el valor por cada volada en el juego?</label>
                <input type="number" name="volada" min='1' step="1">
            </div>
            <div class="form-control">
                <label>¿Cuál es el valor para entrar en el juego?</label>
                <input type="number" name="entrada" min='1'  step="1">
            </div>

            <input type="submit" name="enviar" class="boton" value="Enviar">
        </form>
    </div>
</div>
<?php require_once '../views/layouts/footer.php' ?>