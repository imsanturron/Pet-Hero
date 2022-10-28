<?php namespace Models;

class Resena
{
    private $puntaje; ///del 1 al 10
    private $fecha; ///que se hizo la observacion
    private $observacion; ///comentarios

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
