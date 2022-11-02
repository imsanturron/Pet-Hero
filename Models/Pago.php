<?php namespace Models;

class Pago
{
    private $id; //PK
    private $dniDueno; //FK
    private $dniGuardian; //FK
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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getDniDueno()
    {
        return $this->dniDueno;
    }

    public function setDniDueno($dniDueno): self
    {
        $this->dniDueno = $dniDueno;

        return $this;
    }

    /**
     * Get the value of dniGuardian
     */
    public function getDniGuardian()
    {
        return $this->dniGuardian;
    }

    /**
     * Set the value of dniGuardian
     */
    public function setDniGuardian($dniGuardian): self
    {
        $this->dniGuardian = $dniGuardian;

        return $this;
    }
}
