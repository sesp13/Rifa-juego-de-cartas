<?php

if(isset($_POST['enviar-cambio'])){
    $cantidad = $_SESSION['cantidad'];
    $array = [];
    for($i=0; $i<$cantidad;$i++){
        $posicion =  $_POST["pos-$i"];
        //Verificar que el array tenga elementos únicos
        if(!in_array($posicion, $array)){
            array_push($array,$posicion);
        }
    }
    if(count($array) == $cantidad){
       $tablero->cambiarOrden($array);
       header('Location:juego.php');
    } else {
        $_SESSION['error'] = "Error: Un jugador no puede ocupar 2 o más posiciones distintas";
    }
}