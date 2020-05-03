<?php

class Jugador
{
    private $nombre;
    private $puntaje;
    private $esVolado;
    private $voladas;
    private $deuda;

    //GETTER
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getPuntaje()
    {
        return $this->puntaje;
    }
    public function getVoladas()
    {
        return $this->voladas;
    }

    public function getEsVolado()
    {
        return $this->esVolado;
    }

    public function getDeuda()
    {
        return $this->deuda;
    }

    //SETTER
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setPuntaje($puntaje)
    {
        $this->puntaje = $puntaje;
    }
    public function setVoladas($voladas)
    {
        $this->voladas = $voladas;
    }

    public function setEsVolado($voladas)
    {
        $this->esVolado = $voladas;
    }

    public function setdeuda($deuda)
    {
        $this->deuda = $deuda;
    }

    public function __construct($nombre)
    {
        $this->nombre = $nombre;
        $this->esVolado = false;
        $this->voladas = 0;
        $this->puntaje = 0;
    }

    public function sumarPuntos($puntos)
    {
        $puntosTotales = $this->getPuntaje() + $puntos;
        $this->setPuntaje($puntosTotales);
        //Comprobación para la cantidad de voladas
        $vuelo = $this->getPuntaje() > 100 ? true : false;
        $this->setEsVolado($vuelo);
        $voladas = $vuelo ? $this->getVoladas() + 1 : $this->getVoladas();
        $this->setVoladas($voladas);
    }

    //Invocado cuando un jugador se debe de reingresar al juego
    // public function reingreso()
    // {
    //     // $voladas = $this->getVoladas() + 1;
    //     // $this->setVoladas($voladas);
    //     $this->setEsVolado(false);
    // }

    //Calcular la deuda de un jugador que se retira
    public function calcularDeuda($valorEntrada, $valorVolada)
    {
        $voladas = $this->getVoladas();
        return $valorEntrada + ($voladas * $valorVolada);
    }

    public function getPuntosRestantes()
    {
        $puntaje = $this->getPuntaje();
        return 101 - $puntaje;
    }
}
