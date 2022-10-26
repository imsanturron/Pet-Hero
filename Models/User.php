<?php

namespace Models;

use Models\Solicitud as Solicitud;
use Models\Reserva as Reserva;

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
    private $solicitudes;
    private $reservas;

    function __construct()
    {
        $this->solicitudes = array();
        $this->reservas = array();
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


    public function getSolicitudes()
    {
        return $this->solicitudes;
    }

    public function getSolicitudById($uid)
    {
        foreach ($this->solicitudes as $sol) {
            if ($sol->getId() == $uid)
                return $sol;
        }
        return null;
    }

    public function setSolicitudes($solicitudes): self
    {
        $this->solicitudes = $solicitudes;

        return $this;
    }

    public function addSolicitud(Solicitud $solicitud)
    {
        array_push($this->solicitudes, $solicitud);
    }

    public function getReservas()
    {
        return $this->reservas;
    }

    public function getReservaById($uid)
    {
        foreach ($this->reservas as $res) {
            if ($res->getId() == $uid)
                return $res;
        }
        return null;
    }

    public function setReservas($reservas): self
    {
        $this->reservas = $reservas;

        return $this;
    }

    public function addReserva(Reserva $reserva)
    {
        array_push($this->reservas, $reserva);
    }
}
