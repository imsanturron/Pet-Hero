<?php namespace Models;

use Models\Solicitud as Solicitud;

class Reserva extends Solicitud
{
    private $estado; ///"finalizado", "actual", "proximo"
    private $crearReserva; ///boolean  -- si debe crearse es true
    private $resHechaOrechazada; //bool. ve si ya se hizo o rechazo la reseña. Podria ser atributo de reserva tamb

    public function __construct(Solicitud $solicitud = null)
    {
       // parent::__construct($solicitud->getAnimales(), $solicitud->getFechaInicio(),$solicitud->getFechaFin());
       
       if($solicitud){
        $this->setId($solicitud->getId());
        $this->setFechaInicio($solicitud->getFechaInicio());    
        $this->setFechaFin($solicitud->getFechaFin());   
        $this->setNombreDueno($solicitud->getNombreDueno());   
        $this->setDniDueno($solicitud->getDniDueno());  
        $this->setNombreGuardian($solicitud->getNombreGuardian());   
        $this->setDniGuardian($solicitud->getDniGuardian());
        $this->setDireccionGuardian($solicitud->getDireccionGuardian());   
        $this->setTelefonoDueno($solicitud->getTelefonoDueno());
        $this->setTelefonoGuardian($solicitud->getTelefonoGuardian());

        ///setear estado comaparando con fecha actual.
        $this->estado = "proximo";
        $this->crearReserva = false;
        $this->resHechaOrechazada = false;
    }
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

    /*public function getEstadoDescripcion()
    {
      $ret = "";
      switch($this->estado) {
        case "P":
          $ret = "Pendiente";
          break;
        case "F":
          $ret = "Finalizado";
          break;
        case "C":
          $ret = "Cancelado";
          break;
      }
      return $ret;
    }*/

    /**
     * Get the value of crearReserva
     */
    public function getCrearReserva()
    {
        return $this->crearReserva;
    }

    /**
     * Set the value of crearReserva
     */
    public function setCrearReserva($crearReserva): self
    {
        $this->crearReserva = $crearReserva;

        return $this;
    }

    /**
     * Get the value of resHechaOrechazada
     */
    public function getResHechaOrechazada()
    {
        return $this->resHechaOrechazada;
    }

    /**
     * Set the value of resHechaOrechazada
     */
    public function setResHechaOrechazada($resHechaOrechazada): self
    {
        $this->resHechaOrechazada = $resHechaOrechazada;

        return $this;
    }
}