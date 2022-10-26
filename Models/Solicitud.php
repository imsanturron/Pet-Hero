<?php

namespace Models;

class Solicitud
{

    private $id;
    private $animales;
    private $fechaInicio;
    private $fechaFin;
    private $nombreDueno;
    private $dniDueno;
    private $nombreGuardian;
    private $dniGuardian;
    private $direccion;//guardain
    //private $direccion;//dueno
    //private $telefono;//guardain
    //private $telefono;//dueno


    public function  __construct($animales, $desde, $hasta)
    {
        $this->animales = $animales;
        $this->fechaInicio = $desde;
        $this->fechaFin = $hasta;
        if (isset($_SESSION['loggedUser'])) {
            if ($_SESSION['loggedUser']->getTipo() == 'd') {

                $dueno = $_SESSION['loggedUser'];
                $this->nombreDueno = $dueno->getNombre();
                $this->direccion = $dueno->getDireccion();
            }// else {
                ///caso guardian
            //}
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

    public function getAnimales()
    {
        return $this->animales;
    }

    public function setAnimales($animales): self
    {
        $this->animales = $animales;

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

 
    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }
}
