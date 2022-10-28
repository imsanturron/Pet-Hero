<?php

namespace Models;

class Guardian extends User
{

    private $cuil;
    private $disponibilidadInicio;
    private $disponibilidadFin;
    private $precio;
    private $TamanoACuidar;
    private $reputacion; ///tipo reseña o id de reseñas

    function __construct()
    {
        parent::__construct();
        $this->tipo = 'g';
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

    public function getTamanoACuidar()
    {
        return $this->TamanoACuidar;
    }

    public function setTamanoACuidar($TamanoACuidar): self
    {
        $this->TamanoACuidar = $TamanoACuidar;

        return $this;
    }

    public function getReputacion()
    {
        return $this->reputacion;
    }

    public function setReputacion($reputacion): self
    {
        $this->reputacion = $reputacion;

        return $this;
    }
}
