<?php

require_once 'jugador.php';

class Tablero
{
    private $valorEntrada;
    private $valorVolada;
    private $valorActual;
    //Cantidad de turnos que hay en el juego
    private $turno;
    //Contador del array para saber quién reparte el juego este turno
    private $contadorturno;
    private $jugadores;

    // GETTER

    public function getValorEntrada()
    {
        return $this->valorEntrada;
    }
    public function getValorVolada()
    {
        return $this->valorVolada;
    }
    public function getValorActual()
    {
        return $this->valorActual;
    }
    public function getTurno()
    {
        return $this->turno;
    }

    public function getJugadores()
    {
        return $this->jugadores;
    }

    public function getContadorTurno()
    {
        return $this->contadorturno;
    }

    //SETTER
    public function setValorEntrada($valor)
    {
        $this->valorEntrada = $valor;
    }

    public function setValorVolada($valor)
    {
        $this->valorVolada = $valor;
    }

    public function setValorActual($valor)
    {
        $this->valorActual = $valor;
    }

    public function setTurno($valor)
    {
        $this->turno = $valor;
    }

    public function setJugadores($jugadores)
    {
        $this->jugadores = $jugadores;
    }

    public function setContadorTurno($contador)
    {
        $this->contadorturno = $contador;
    }

    public function __construct($valorEntrada, $valorVolada, $jugadores)
    {
        $this->valorEntrada = $valorEntrada;
        $this->valorVolada = $valorVolada;
        $this->valorActual = 0;
        $this->jugadores = $jugadores;
        $this->turno = 1;
        $this->contadorturno = 0;
    }

    public function repartidorTurno()
    {
        $jugadores = $this->getJugadores();
        $indice = $this->getContadorTurno();
        return $jugadores[$indice]->getNombre();
    }

    //Final del turno
    public function finalDeTurno()
    {
        if (isset($_POST['enviar'])) {
            $jugadores = $this->getJugadores();
            foreach ($jugadores as $indice => $jugador) {
                //Comprobar valores
                if ($_POST["jugador-$indice"] == ''  || !is_numeric($_POST["jugador-$indice"])) {
                    $_SESSION['error'] = 'Error insertando puntajes, inténtalo de nuevo';
                    return true;
                }

                $puntos = intval($_POST["jugador-$indice"]);
                //Suma de puntos por jugador
                $jugador->sumarPuntos($puntos);
            }

            //Ajuste de puntajes para jugadores volados 
            //En una versión del futuro preguntaremos quienes desean continuar
            $volados = array();
            $puntajeMaximo = $this->getDatosFinales();
            foreach ($jugadores as $jugador) {
                if ($jugador->getEsVolado()) {
                    $jugador->setPuntaje($puntajeMaximo);
                    $volados[] = $jugador;
                    //Quitarle la categoría de volado al jugador
                    $jugador->setEsVolado(false);
                }
            }

            //Pasar los volados a la sección
            $_SESSION['volados'] = $volados;

            //Pasar la variable a este objeto
            $contadorTurnos = $this->getContadorTurno() < $_SESSION['cantidad'] - 1 ? $this->getContadorTurno() + 1 : 0;
            $turno = $this->getTurno() + 1;

            //Actualizar el objeto
            $this->setContadorTurno($contadorTurnos);
            $this->setTurno($turno);
            $this->setJugadores($jugadores);
            header('Location:juego.php');
        }
    }

    public function getDatosFinales($actualizar = null)
    {
        $jugadores = $this->getJugadores();
        //Vivos comprueba qué jugadores siguen en pie para la lucha
        $vivos = array();
        $puntaje = 0;
        //Obtención del puntaje máximo
        foreach ($jugadores as $indice => $jugador) {
            $esVolado = $jugador->getEsVolado();
            if (!$esVolado && $jugador->getPuntaje() > $puntaje) {
                $puntaje = $jugador->getPuntaje();
            }

            if (!$esVolado && !isset($actualizar)) {
                array_push($vivos, $indice);
            }
        }

        //Redirección a la página del ganador
        if (count($vivos) == 1 && !isset($actualizar)) {
            $_SESSION['ganador'] = $vivos[0];
        }

        return $puntaje;
    }

    public function getPerdedores($ganador)
    {
        $indice = $ganador;
        $jugadores = $this->getJugadores();
        unset($jugadores[$indice]);
        //Restar 1 volada para cada perdedor, ya que la última volada no cuenta
        foreach ($jugadores as $perdedor) {
            $voladas = $perdedor->getVoladas();
            $perdedor->setVoladas($voladas - 1);
        }
        return $jugadores;
    }

    public function eliminarJugador($id)
    {
        $valorActual = $this->getValorActual();
        $jugadores = $this->getJugadores();
        $cantidad = $_SESSION['cantidad'];
        $contadorTurno = $this->getContadorTurno();

        if ($cantidad < 3) {
            $_SESSION['error'] = 'Error, no se permite que el juego quede con un solo jugador';
            return true;
        }
        if ($id <= count($jugadores)) {

            //Captura del jugador a eliminar
            $jugador = $jugadores[$id];

            //Bajar el número de voladas para el jugador a salir
            $voladasJugador = $jugador->getVoladas();
            $voladasJugador = $voladasJugador != 0 ? $voladasJugador - 1 : 0;
            $jugador->setVoladas($voladasJugador);
            $deudaJugador = $jugador->calcularDeuda($_SESSION['volada'], $_SESSION['entrada']);
            //Aporte de la deuda al valor actual
            $valorActual =+ $deudaJugador;
            $this->setValorActual($valorActual);

            //Calculo de la nueva cantidad
            $_SESSION['cantidad'] = $cantidad - 1;
            $contadorTurno = $contadorTurno != 0 ? $contadorTurno - 1 : 0;
            $this->setContadorTurno($contadorTurno);

            //Eliminación del jugador del array jugadores
            unset($jugadores[$id]);
            //Creación de un nuevo array con los indices correctos
            $nuevosJugadores  = [];
            foreach($jugadores as $x){
                $nuevosJugadores[] = $x;
            }
            $this->setJugadores($nuevosJugadores);

            $_SESSION['error'] = "El jugador {$jugador->getNombre()} ha sido eliminado y debe aportar  $ $deudaJugador";
            return true;
        } else {
            $_SESSION['error'] = 'Error, índice mal enviado';
            return true;
        }
    }
}
