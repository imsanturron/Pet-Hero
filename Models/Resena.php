<?php namespace Models;

class Resena
{
    private $puntaje;
    private $fecha;
    private $observacion;

    public function getPuntaje()
    {
        return $this->puntaje;
    }

    public function setPuntaje($puntaje): self
    {
        $this->puntaje = $puntaje;

        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getObservacion()
    {
        return $this->observacion;
    }

    public function setObservacion($observacion): self
    {
        $this->observacion = $observacion;

        return $this;
    }
}
