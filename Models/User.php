<?php

namespace Models;

class User
{
    protected $username;
    protected $password; 
    protected $nombre;
    protected $dni;
    protected $email;
    protected $direccion;
    //protected $pais;
    protected $tipo; //char = "g" || "d"
    private $reservas;

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
    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

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

    public function getTipo()
    {
        return $this->tipo;
    }

    public function setTipo($tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get the value of reservas
     */ 
    public function getReservas()
    {
        return $this->reservas;
    }

    /**
     * Set the value of reservas
     *
     * @return  self
     */ 
    public function setReservas($reservas)
    {
        $this->reservas = $reservas;

        return $this;
    }
}
