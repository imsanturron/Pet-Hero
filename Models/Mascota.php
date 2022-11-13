<?php

namespace Models;

class Mascota
{

    private $dniDueno; //FK
    private $id; //PK
    private $especie;
    private $nombre;
    private $raza;
    private $tamano;
    private $observaciones;
    private $fotoMascota;
    private $video;
    private $planVacunacion;
    //private $ocupada; true false y ver si podemos mandar solicitud con mascota reservada. puede ser intermedia de fechas

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

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

    public function getRaza()
    {
        return $this->raza;
    }

    public function setRaza($raza): self
    {
        $this->raza = $raza;

        return $this;
    }


    public function getTamano()
    {
        return $this->tamano;
    }

    public function setTamano($tamano): self
    {
        $this->tamano = $tamano;

        return $this;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
    }
    public function getFotoMascota()
    {
        return $this->fotoMascota;
    }

    public function setFotoMascota($fotoMascota): self
    {
        $this->fotoMascota = $fotoMascota;

        return $this;
    }
    public function getVideo()
    {
        return $this->video;
    }

    public function setVideo($video): self
    {
        $this->video = $video;

        return $this;
    }
    public function getPlanVacunacion()
    {
        return $this->planVacunacion;
    }

    public function setPlanVacunacion($planVacunacion): self
    {
        $this->planVacunacion = $planVacunacion;

        return $this;
    }

    public function getEspecie()
    {
        return $this->especie;
    }

    public function setEspecie($especie): self
    {
        $this->especie = $especie;

        return $this;
    }

    public function getIdSoliRes()
    {
        return $this->idSoliRes;
    }

    public function setIdSoliRes($idSoliRes): self
    {
        $this->idSoliRes = $idSoliRes;

        return $this;
    }
}
