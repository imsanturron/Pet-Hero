<?php

namespace Models;

class Guardian extends User
{
    private $disponibilidadInicio;
    private $disponibilidadFin;
    private $precio;
    private $TamanoACuidar; // chico - mediano - grande
    private $cantResenas; ///tipo reseña o id de reseñas
    private $puntajeTotal;
    private $puntajePromedio;

    function __construct()
    {
        $this->tipo = 'g';
        $this->cantResenas = 0;
        $this->puntajeTotal = 0;
        $this->puntajePromedio = 0;
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

    public function setDisponibilidadFin($disponibilidadFin): self
    {
        $this->disponibilidadFin = $disponibilidadFin;

        return $this;
    }

    public function getDisponibilidadInicio()
    {
        return $this->disponibilidadInicio;
    }

    public function setDisponibilidadInicio($disponibilidadInicio): self
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


    public function getCantResenas()
    {
        return $this->cantResenas;
    }

    public function setCantResenas($cantResenas): self
    {
        $this->cantResenas = $cantResenas;

        return $this;
    }

    public function getPuntajeTotal()
    {
        return $this->puntajeTotal;
    }

    public function setPuntajeTotal($puntajeTotal): self
    {
        $this->puntajeTotal = $puntajeTotal;

        return $this;
    }

    public function getPuntajePromedio()
    {
        return $this->puntajePromedio;
    }

    public function setPuntajePromedio($puntajePromedio): self
    {
        $this->puntajePromedio = $puntajePromedio;

        return $this;
    }
}
