<?php namespace Models;
class Mascota{

    private $dniDueno;
    private $id;
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

  

    /**
     * Get the value of tamano
     */ 
    public function getTamano()
    {
        return $this->tamano;
    }

    /**
     * Set the value of tamano
     *
     * @return  self
     */ 
    public function setTamano($tamano)
    {
        $this->tamano = $tamano;

        return $this;
    }

    /**
     * Get the value of observaciones
     */ 
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set the value of observaciones
     *
     * @return  self
     */ 
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }
}
?>