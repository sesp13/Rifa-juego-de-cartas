<?php
require_once '../classes/jugador.php';
require_once '../classes/tablero.php';
if (!isset($_SESSION)) {
    session_start();
}
require_once '../helpers/utils.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rifa</title>
    <link rel="stylesheet" href='../assets/styles.css'>
</head>

<body>
    <div class="header">
        <header>
            <a href="index.php">
                <p>Rifas</p>
            </a>
        </header>
    </div>