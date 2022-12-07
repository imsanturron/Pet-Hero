<?php

namespace Models;

class chat
{
    private $id; //PK
    private $dniDueno; //FK
    private $dniGuardian; //FK
    private $nombreDueno; //NO ESTA EN DB
    private $nombreGuardian; //NO ESTA EN DB
    private $mensaje;
    private $fecha; // YYYY/MM/DD HH/MM/SS
    private $sender; // char: guardian = 'g' - dueño = 'd' --> quien envio el chat


    public function  __construct(Guardian $guardian = null, Dueno $dueno = null, $mensaje = null, $sender = null)
    {
        if (isset($guardian) && isset($dueno)) {
            $this->nombreDueno = $dueno->getNombre();
            $this->dniDueno = $dueno->getDni();
            $this->nombreGuardian = $guardian->getNombre();
            $this->dniGuardian = $guardian->getdni();
            $this->mensaje = $mensaje;
            $this->fecha = date("Y-m-d H:i:s");
            $this->sender = $sender;
        }
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

    public function getDniGuardian()
    {
        return $this->dniGuardian;
    }

    public function setDniGuardian($dniGuardian): self
    {
        $this->dniGuardian = $dniGuardian;

        return $this;
    }

    public function getNombreDueno()
    {
        return $this->nombreDueno;
    }

    public function setNombreDueno($nombreDueno): self
    {
        $this->nombreDueno = $nombreDueno;

        return $this;
    }

    public function getNombreGuardian()
    {
        return $this->nombreGuardian;
    }

    public function setNombreGuardian($nombreGuardian): self
    {
        $this->nombreGuardian = $nombreGuardian;

        return $this;
    }

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function setMensaje($mensaje): self
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getSender()
    {
        return $this->sender;
    }

    public function setSender($sender): self
    {
        $this->sender = $sender;

        return $this;
    }
}
