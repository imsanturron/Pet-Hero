<?php namespace Models;
class Mascota{

<<<<<<< HEAD
=======
    private $dniDueno;
    private $id;
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
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
<<<<<<< HEAD
=======
    
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
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7

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