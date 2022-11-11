<?php

namespace Models;

use Models\Guardian as Guardian;
use Models\Dueno as Dueno;
//use JsonSerializable;
//use Serializable;

class Solicitud //implements JsonSerializable
{
    protected $id;
    protected $fechaInicio;
    protected $fechaFin;
    protected $nombreDueno;
    protected $dniDueno;
    protected $nombreGuardian;
    protected $dniGuardian;
    protected $direccionGuardian;
    protected $telefonoDueno;
    protected $telefonoGuardian;
    protected $esPago = false; //booleano de pago

    public function  __construct(Guardian $guardian = null, Dueno $dueno = null, $desde = "", $hasta = "")
    {
        if (isset($guardian) && isset($dueno) && isset($desde)) {
            $this->fechaInicio = $desde;
            $this->fechaFin = $hasta;
            $this->nombreDueno = $dueno->getNombre();
            $this->dniDueno = $dueno->getDni();
            $this->nombreGuardian = $guardian->getNombre();
            $this->dniGuardian = $guardian->getdni();
            $this->direccionGuardian = $guardian->getDireccion();
            $this->telefonoDueno = $dueno->getTelefono();
            $this->telefonoGuardian = $guardian->getTelefono();
        }
    }

    /*public function jsonSerialize(){
        $solicitud["id"] = $this->id;
    }*/




    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio($fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    public function setFechaFin($fechaFin): self
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function getNombreDueno()
    {
        return $this->nombreDueno;
    }

    public function setNombreDueno($nombreDueno): self
    {
        $this->nombreDueno = $nombreDueno;

        return $this;
    }

    public function getDniDueno()
    {
        return $this->dniDueno;
    }

    public function setDniDueno($dniDueno): self
    {
        $this->dniDueno = $dniDueno;

        return $this;
    }

    public function getNombreGuardian()
    {
        return $this->nombreGuardian;
    }

    public function setNombreGuardian($nombreGuardian): self
    {
        $this->nombreGuardian = $nombreGuardian;

        return $this;
    }

    public function getDniGuardian()
    {
        return $this->dniGuardian;
    }

    public function setDniGuardian($dniGuardian): self
    {
        $this->dniGuardian = $dniGuardian;

        return $this;
    }

    public function getDireccionGuardian()
    {
        return $this->direccionGuardian;
    }

    public function setDireccionGuardian($direccionGuardian): self
    {
        $this->direccionGuardian = $direccionGuardian;

        return $this;
    }

    public function getTelefonoGuardian()
    {
        return $this->telefonoGuardian;
    }

    public function setTelefonoGuardian($telefonoGuardian): self
    {
        $this->telefonoGuardian = $telefonoGuardian;

        return $this;
    }

    public function getTelefonoDueno()
    {
        return $this->telefonoDueno;
    }

    public function setTelefonoDueno($telefonoDueno): self
    {
        $this->telefonoDueno = $telefonoDueno;

        return $this;
    }

    public function getEsPago()
    {
        return $this->esPago;
    }

    public function setEsPago($esPago): self
    {
        $this->esPago = $esPago;

        return $this;
    }
}
