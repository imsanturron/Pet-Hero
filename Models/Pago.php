<?php

namespace Models;

class Pago
{
    private $id; //PK mismo id que solicitud/reserva/reseña --  //ver si cambiar por numero grande
    private $dniDueno; //FK
    private $dniGuardian; //FK
    private $precioGuardian;
    private $montoAPagar; //50% de precio guardian
    private $primerPagoReserva; //booleano
    private $pagoFinal; //booleano
    private $formaDePago; //Credito - debito

    public function  __construct(Solicitud $solicitud = null, Guardian $guardian = null)
    {
        if (isset($solicitud) && isset($guardian)) {
            $this->id = $solicitud->getId();
            $this->dniDueno = $solicitud->getDniDueno();
            $this->dniGuardian = $solicitud->getDniGuardian();
            $this->precioGuardian = $guardian->getPrecio();
            $this->montoAPagar = ($guardian->getPrecio() / 2);
            $this->primerPagoReserva = false;
            $this->pagoFinal = false;
            //$this->fecha = false;
            $this->formaDePago = "";
        }
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

    public function getDniGuardian()
    {
        return $this->dniGuardian;
    }

    public function setDniGuardian($dniGuardian): self
    {
        $this->dniGuardian = $dniGuardian;

        return $this;
    }

    public function getIdSolicitud()
    {
        return $this->idSolicitud;
    }

    public function setIdSolicitud($idSolicitud): self
    {
        $this->idSolicitud = $idSolicitud;

        return $this;
    }

    public function getPrecioGuardian()
    {
        return $this->precioGuardian;
    }

    public function setPrecioGuardian($precioGuardian): self
    {
        $this->precioGuardian = $precioGuardian;

        return $this;
    }

    public function getMontoAPagar()
    {
        return $this->montoAPagar;
    }

    public function setMontoAPagar($montoAPagar): self
    {
        $this->montoAPagar = $montoAPagar;

        return $this;
    }

    public function getPrimerPagoReserva()
    {
        return $this->primerPagoReserva;
    }

    public function setPrimerPagoReserva($primerPagoReserva): self
    {
        $this->primerPagoReserva = $primerPagoReserva;

        return $this;
    }

    public function getPagoFinal()
    {
        return $this->pagoFinal;
    }

    public function setPagoFinal($pagoFinal): self
    {
        $this->pagoFinal = $pagoFinal;

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
