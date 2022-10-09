<?php namespace Models;
class dueno extends User{
    private $mascotas;
    private $telefono;

    function __construct()
    {
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
}
?>