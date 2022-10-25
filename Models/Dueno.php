<?php namespace Models;
class dueno extends User{
    private $mascotas;
    private $telefono;////user

    function __construct()
    {
        parent::__construct();
        $this->tipo = 'd';
        $this->mascotas = array();
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getMascotas()
    {
        return $this->mascotas;
    }

    public function setMascotas($mascotas): self
    {
        $this->mascotas = $mascotas;

        return $this;
    }
    
    public function addMascota($msc){
        array_push($this->mascotas, $msc);
    }
}
?>