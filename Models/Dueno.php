<?php namespace Models;
class dueno extends User{
    //private $mascotas; ///ids

    function __construct()
    {
        parent::__construct();
        $this->tipo = 'd';
        //$this->mascotas = array();
    }

    /*public function getMascotas()
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
    }*/
}
?>