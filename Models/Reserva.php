<?php namespace Models;

use Models\Solicitud as Solicitud;

class Reserva extends Solicitud
{
    private $estado; ///"finalizado", "actual", "proximo"

    public function __construct(Solicitud $solicitud = null)
    {
       // parent::__construct($solicitud->getAnimales(), $solicitud->getFechaInicio(),$solicitud->getFechaFin());
       
       if($solicitud){
       $this->setId($solicitud->GetId());
        $this->setFechaInicio($solicitud->GetFechaInicio());    
        $this->setFechaFin($solicitud->GetFechaFin());   
        $this->setNombreDueno($solicitud->GetNombreDueno());   
        $this->setDniDueno($solicitud->GetDniDueno());  
        $this->setNombreGuardian($solicitud->GetNombreGuardian());   
        $this->setDniGuardian($solicitud->GetDniGuardian());
        $this->setDireccionGuardian($solicitud->GetDireccionGuardian());   
        $this->setTelefonoDueno($solicitud->GetTelefonoDueno());
        $this->setTelefonoGuardian($solicitud->GetTelefonoGuardian());

        ///setear estado comaparando con fecha actual.
        $this->estado = "proximo";
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
}
