<?php namespace Models;
class Guardian extends User{

    private $cuil;
    private $disponibilidad;
    private $precio;

    function __construct()
    {
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

    public function getDisponibilidad()
    {
        return $this->disponibilidad;
    }

    public function setDisponibilidad($disponibilidad): self
    {
        $this->disponibilidad = $disponibilidad;

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
}
