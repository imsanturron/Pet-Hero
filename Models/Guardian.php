<?php namespace Models;
<<<<<<< HEAD
class Guardian{

    private $username;//////////
    private $password;//////////
    private $nombre;
    private $direccion;
    private $cuil;
    private $disponibilidad;
    private $precio;
    
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
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre): self
    {
        $this->nombre = $nombre;

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
class Guardian extends User{

    private $cuil;
    private $disponibilidadInicio;
    private $disponibilidadFin;
    private $precio;
    private $reservas;

    function __construct()
    {
        $this->tipo = 'g';
        $this->reservas = array();
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
    }

    public function getCuil()
    {
        return $this->cuil;
    }

    public function setCuil($cuil): self
    {
        $this->cuil = $cuil;

        return $this;
    }

<<<<<<< HEAD
    public function getDisponibilidad()
    {
        return $this->disponibilidad;
    }

    public function setDisponibilidad($disponibilidad): self
    {
        $this->disponibilidad = $disponibilidad;

        return $this;
    }

=======
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
    public function getPrecio()
    {
        return $this->precio;
    }

    public function setPrecio($precio): self
    {
        $this->precio = $precio;

        return $this;
    }
<<<<<<< HEAD
}
=======

    public function getReservas()
    {
        return $this->reservas;
    }

    public function setReservas($reservas): self
    {
        $this->reservas = $reservas;

        return $this;
    }
 
    public function getDisponibilidadFin()
    {
        return $this->disponibilidadFin;
    }

    /**
     * Set the value of disponibilidadFin
     *
     * @return  self
     */ 
    public function setDisponibilidadFin($disponibilidadFin)
    {
        $this->disponibilidadFin = $disponibilidadFin;

        return $this;
    }

    public function getDisponibilidadInicio()
    {
        return $this->disponibilidadInicio;
    }

    /**
     * Set the value of disponibilidadInicio
     *
     * @return  self
     */ 
    public function setDisponibilidadInicio($disponibilidadInicio)
    {
        $this->disponibilidadInicio = $disponibilidadInicio;

        return $this;
    }
}
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
