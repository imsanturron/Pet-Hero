<?php

namespace Models;

use Models\Guardian as Guardian;
use Models\Dueno as Dueno;

class Solicitud
{
    protected $id; //mismo id que pago/reserva/reseña, en caso de aceptarse.
    protected $fechaInicio;
    protected $fechaFin;
    protected $nombreDueno; //no esta en DB
    protected $dniDueno; //FK
    protected $nombreGuardian; //no esta en DB
    protected $dniGuardian; //FK
    protected $direccionGuardian; //no esta en DB
    protected $telefonoDueno; //no esta en DB
    protected $telefonoGuardian; //no esta en DB
    protected $esPago = false; //booleano de pago. Es true una vez que se acepta y el pago debe realizarse.

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
