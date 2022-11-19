<?php

namespace Models;

use Models\Solicitud as Solicitud;

class Reserva extends Solicitud
{
  private $estado; ///"finalizado", "actual", "proximo"
  private $crearResena; ///boolean  -- si debe crearse es true
  private $resHechaOrechazada; //bool. ve si ya se hizo o rechazo la reseña. Podria ser atributo de reserva tamb

  public function __construct(Solicitud $solicitud = null)
  {
    if ($solicitud) {
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
      $this->crearResena = false;
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

  public function getCrearResena()
  {
    return $this->crearResena;
  }

  public function setCrearResena($crearResena): self
  {
    $this->crearResena = $crearResena;

    return $this;
  }

  public function getResHechaOrechazada()
  {
    return $this->resHechaOrechazada;
  }

  public function setResHechaOrechazada($resHechaOrechazada): self
  {
    $this->resHechaOrechazada = $resHechaOrechazada;

    return $this;
  }
}
