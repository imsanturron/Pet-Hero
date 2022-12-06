<?php

namespace Models;

class Tarjeta
{
    private $numeroTarjeta; //PK
    private $dniPropietario; //FK
    private $nombreTarjeta; // nombre que aparece en tarjeta
    private $vencimiento; // 'MM/YY'
    private $codigoSeguridad; //Codigo de 3 digitos del lado posterior

    public function __construct($numTarj = null, $dniP = null, $nombreTarj = null, $vencim = null, $codigo = null)
    {
        if (isset($numTarj) && isset($dniP) && isset($vencim)) {
            $this->numeroTarjeta = $numTarj;
            $this->dniPropietario = $dniP;
            $this->nombreTarjeta = $nombreTarj;
            $this->vencimiento = $vencim;
            $this->codigoSeguridad = $codigo;
        }
    }

    public function getNumeroTarjeta()
    {
        return $this->numeroTarjeta;
    }

    public function setNumeroTarjeta($numeroTarjeta): self
    {
        $this->numeroTarjeta = $numeroTarjeta;

        return $this;
    }

    public function getNombreTarjeta()
    {
        return $this->nombreTarjeta;
    }

    public function setNombreTarjeta($nombreTarjeta): self
    {
        $this->nombreTarjeta = $nombreTarjeta;

        return $this;
    }

    public function getVencimiento()
    {
        return $this->vencimiento;
    }

    public function setVencimiento($vencimiento): self
    {
        $this->vencimiento = $vencimiento;

        return $this;
    }

    public function getCodigoSeguridad()
    {
        return $this->codigoSeguridad;
    }

    public function setCodigoSeguridad($codigoSeguridad): self
    {
        $this->codigoSeguridad = $codigoSeguridad;

        return $this;
    }

    public function getDniPropietario()
    {
        return $this->dniPropietario;
    }

    public function setDniPropietario($dniPropietario): self
    {
        $this->dniPropietario = $dniPropietario;

        return $this;
    }
}
