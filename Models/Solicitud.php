<?php

namespace Models;

class Solicitud
{

    private $fechaInicio;
    private $fechaFin;
    private $nombreDueno;
    private $dniDueno;
    private $nombreGuardian;
    private $dniGuardian;
    private $direccion;


    public function  __construct($desde, $hasta)
    {
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

    /**
     * Get the value of nombreDueno
     */
    public function getNombreDueno()
    {
        return $this->nombreDueno;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion()
    {
        return $this->direccion;
    }
}
