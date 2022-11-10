<?php

namespace Models;

class SolixMasc
{
    private $idSolixMasc; //PK
    private $idSolicitud; //FK
    private $idMascota; //FK


    public function getIdSolixMasc()
    {
        return $this->idSolixMasc;
    }

    public function setIdSolixMasc($idSolixMasc): self
    {
        $this->idSolixMasc = $idSolixMasc;

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

    public function getIdMascota()
    {
        return $this->idMascota;
    }

    public function setIdMascota($idMascota): self
    {
        $this->idMascota = $idMascota;

        return $this;
    }
}
