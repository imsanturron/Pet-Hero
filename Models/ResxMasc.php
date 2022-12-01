<?php

namespace Models;

class ResxMasc
{
    private $idResxMasc; //PK
    private $idReserva; //FK
    private $idMascota; //FK


    public function getIdResxMasc()
    {
        return $this->idResxMasc;
    }

    public function setIdResxMasc($idResxMasc): self
    {
        $this->idResxMasc = $idResxMasc;

        return $this;
    }

    public function getIdMascota()
    {
        return $this->idMascota;
    }

    public function setIdMascota($idMascota): self
    {
        $this->idMascota = $idMascota;

        return $this;
    }

    public function getIdReserva()
    {
        return $this->idReserva;
    }

    public function setIdReserva($idReserva): self
    {
        $this->idReserva = $idReserva;

        return $this;
    }
}
