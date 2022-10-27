<?php namespace Models;

use Models\Solicitud as Solicitud;

class Reserva extends Solicitud
{
    private $estado; ///"finalizado", "actual", "proximo"

    public function __construct(Solicitud $solicitud = null)
    {
        parent::__construct($solicitud->getAnimales(), $solicitud->getFechaInicio(),$solicitud->getFechaFin());
        
        ///setear estado comaparando con fecha actual.
        $this->estado = "proximo";
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
