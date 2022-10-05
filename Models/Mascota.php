<?php namespace Models;
class Mascota{

    private $dniDueno;
    private $nombre;
    private $raza;
    private $tamano;
    private $observaciones;
    
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getdniDueno()
    {
        return $this->dniDueno;
    }

    public function setdniDueno($dniDueno): self
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
}
?>