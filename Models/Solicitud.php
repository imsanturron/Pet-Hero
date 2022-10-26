<?php

namespace Models;

class Solicitud
{

    private $animales;
    private $fechaInicio;
    private $fechaFin;
    private $nombreDueno;
    private $dniDueno;
    private $nombreGuardian;
    private $dniGuardian;
    private $direccion;


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

    /**
     * Set the value of nombreDueno
     *
     * @return  self
     */
    public function setNombreDueno($nombreDueno)
    {
        $this->nombreDueno = $nombreDueno;

        return $this;
    }

    /**
     * Set the value of direccion
     *
     * @return  self
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getNombreDueno()
    {
        return $this->nombreDueno;
    }

    public function getDireccion()
    {
        return $this->direccion;
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
}
