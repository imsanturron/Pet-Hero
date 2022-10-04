<?php namespace Models;

class Reserva
{
    private $fechaDeInicio;
    private $fechaFinal;
    private $horarios;
    private $estado;

    public function getFechaDeInicio()
    {
        return $this->fechaDeInicio;
    }

    public function setFechaDeInicio($fechaDeInicio): self
    {
        $this->fechaDeInicio = $fechaDeInicio;

        return $this;
    }

    public function getFechaFinal()
    {
        return $this->fechaFinal;
    }

    public function setFechaFinal($fechaFinal): self
    {
        $this->fechaFinal = $fechaFinal;

        return $this;
    }

    public function getHorarios()
    {
        return $this->horarios;
    }

    public function setHorarios($horarios): self
    {
        $this->horarios = $horarios;

        return $this;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
