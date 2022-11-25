<?php

namespace Models;

class Tarjeta
{
    private $numeroTarjeta; //PK
    private $dniPropietario; //FK
    private $nombreTarjeta;
    private $vencimiento;
    private $codigoSeguridad;

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
