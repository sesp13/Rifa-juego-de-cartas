<?php

class Jugador
{
    private $nombre;
    private $puntaje;
    private $puntajeAdquirido;
    private $puntajePostVuelo;
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
    public function getPuntajeAdquirido()
    {
        return $this->puntajeAdquirido;
    }

    public function getPuntajePostVuelo()
    {
        return $this->puntajePostVuelo;
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

    public function getTope()
    {
        return $this->tope;
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

    public function setPuntajeAdquirido($puntaje)
    {
        $this->puntajeAdquirido = $puntaje;
    }

    public function setPuntajePostVuelo($puntaje)
    {
        $this->puntajePostVuelo = $puntaje;
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

    public function setTope($tope)
    {
        $this->tope = $tope;
    }

    public function __construct($nombre, $tope)
    {
        $this->nombre = $nombre;
        $this->esVolado = false;
        $this->voladas = 0;
        $this->puntaje = 0;
        $this->tope = $tope;
    }

    public function sumarPuntos($puntos)
    {
        //Seteado de los puntos adquiridos
        $this->setPuntajeAdquirido($puntos);

        $puntosTotales = $this->getPuntaje() + $puntos;
        //Seteado de los puntos totales
        $this->setPuntaje($puntosTotales);

        //Comprobación de la volada
        $vuelo = $this->getPuntaje() > $this->getTope() ? true : false;
        $this->setEsVolado($vuelo);


        //Uso del puntaje post vuelo para calculos si se requiere editar un turno
        $puntajePostVuelo = $this->getPuntaje();
        $this->setPuntajePostVuelo($puntajePostVuelo);

        //Seteo de la cantidad de voladas
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
        return $this->getTope() - $puntaje + 1;
    }

    //Este método se usa cuando se edita un turno
    public function devolverCambios()
    {
        $esVolado = $this->getEsVolado();
        $voladas = $this->getVoladas();
        $puntajeAdquirido = $this->getPuntajeAdquirido();
        $puntajePostVuelo = $this->getPuntajePostVuelo();

        $puntajeAnterior = $puntajePostVuelo - $puntajeAdquirido;

        if($esVolado){
            $valorVoladas = $voladas > 0 ? $voladas - 1 : 0;
            $this->setVoladas($valorVoladas);
        }

        $this->setPuntaje($puntajeAnterior);
    }

    public function quitarVolado()
    {
        $this->setEsVolado(false);
    }
}
