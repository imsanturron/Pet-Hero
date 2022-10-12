<?php namespace Models;
<<<<<<< HEAD
class dueno{


    private $username;//////////////
    private $password;//////////////
    private $nombre;
    private $dni;
    private $direccion;
    private $telefono;

    
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }
    public function getUserName()
    {
        return $this->username;
    }

    public function setUserName($username): self
    {
        $this->username = $username;

        return $this;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

    public function setDireccion($direccion): self
    {
        $this->direccion = $direccion;

        return $this;
=======
class dueno extends User{
    private $mascotas;
    private $telefono;////user

    function __construct()
    {
        $this->tipo = 'd';
        $this->mascotas = array();
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
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
<<<<<<< HEAD
=======

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
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
}
?>