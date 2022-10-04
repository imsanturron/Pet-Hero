<?php namespace Models;

class Pago
{
    private $monto;
    private $fecha;
    private $formaDePago;

    public function getMonto()
    {
        return $this->monto;
    }

    public function setMonto($monto): self
    {
        $this->monto = $monto;

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

    public function getFormaDePago()
    {
        return $this->formaDePago;
    }

    public function setFormaDePago($formaDePago): self
    {
        $this->formaDePago = $formaDePago;

        return $this;
    }
}
