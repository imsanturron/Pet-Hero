<?php namespace Models;
class Guardian extends User{

    private $cuil;
    private $disponibilidadInicio;
    private $disponibilidadFin;
    private $precio;
    private $reservas;

    function __construct()
    {
        $this->tipo = 'g';
        $this->reservas = array();
    }

    public function getCuil()
    {
        return $this->cuil;
    }

    public function setCuil($cuil): self
    {
        $this->cuil = $cuil;

        return $this;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getReservas()
    {
        return $this->reservas;
    }

    public function setReservas($reservas): self
    {
        $this->reservas = $reservas;

        return $this;
    }
 
    public function getDisponibilidadFin()
    {
        return $this->disponibilidadFin;
    }

    /**
     * Set the value of disponibilidadFin
     *
     * @return  self
     */ 
    public function setDisponibilidadFin($disponibilidadFin)
    {
        $this->disponibilidadFin = $disponibilidadFin;

        return $this;
    }

    public function getDisponibilidadInicio()
    {
        return $this->disponibilidadInicio;
    }

    /**
     * Set the value of disponibilidadInicio
     *
     * @return  self
     */ 
    public function setDisponibilidadInicio($disponibilidadInicio)
    {
        $this->disponibilidadInicio = $disponibilidadInicio;

        return $this;
    }
}