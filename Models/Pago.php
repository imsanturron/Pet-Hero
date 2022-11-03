<?php namespace Models;

class Pago
{
    private $id; //PK
    private $dniDueno; //FK
    private $dniGuardian; //FK
    private $idSolicitud; //FK
    private $precioGuardian;
    private $montoAPagar; //50% de precio guardian
    private $primerPagoReserva; //booleano
    private $pagoFinal; //booleano
    private $fecha;
    private $formaDePago;

    

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of dniDueno
     */
    public function getDniDueno()
    {
        return $this->dniDueno;
    }

    /**
     * Set the value of dniDueno
     */
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

    /**
     * Get the value of idSolicitud
     */
    public function getIdSolicitud()
    {
        return $this->idSolicitud;
    }

    /**
     * Set the value of idSolicitud
     */
    public function setIdSolicitud($idSolicitud): self
    {
        $this->idSolicitud = $idSolicitud;

        return $this;
    }

    /**
     * Get the value of precioGuardian
     */
    public function getPrecioGuardian()
    {
        return $this->precioGuardian;
    }

    /**
     * Set the value of precioGuardian
     */
    public function setPrecioGuardian($precioGuardian): self
    {
        $this->precioGuardian = $precioGuardian;

        return $this;
    }

    /**
     * Get the value of montoAPagar
     */
    public function getMontoAPagar()
    {
        return $this->montoAPagar;
    }

    /**
     * Set the value of montoAPagar
     */
    public function setMontoAPagar($montoAPagar): self
    {
        $this->montoAPagar = $montoAPagar;

        return $this;
    }

    /**
     * Get the value of primerPagoReserva
     */
    public function getPrimerPagoReserva()
    {
        return $this->primerPagoReserva;
    }

    /**
     * Set the value of primerPagoReserva
     */
    public function setPrimerPagoReserva($primerPagoReserva): self
    {
        $this->primerPagoReserva = $primerPagoReserva;

        return $this;
    }

    /**
     * Get the value of pagoFinal
     */
    public function getPagoFinal()
    {
        return $this->pagoFinal;
    }

    /**
     * Set the value of pagoFinal
     */
    public function setPagoFinal($pagoFinal): self
    {
        $this->pagoFinal = $pagoFinal;

        return $this;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     */
    public function setFecha($fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get the value of formaDePago
     */
    public function getFormaDePago()
    {
        return $this->formaDePago;
    }

    /**
     * Set the value of formaDePago
     */
    public function setFormaDePago($formaDePago): self
    {
        $this->formaDePago = $formaDePago;

        return $this;
    }
}
