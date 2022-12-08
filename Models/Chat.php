<?php

namespace Models;

class chat
{
    private $idC; //PK
    private $dniDueno; //FK
    private $dniGuardian; //FK
    private $nombreDueno; //NO ESTA EN DB
    private $nombreGuardian; //NO ESTA EN DB
    private $nuevo; // Hay mensajes nuevos. Boolean
    private $senderUlt; // char: guardian = 'g' - dueño = 'd' --> quien envio el chat


    public function  __construct(Guardian $guardian = null, Dueno $dueno = null, $senderUlt = null)
    {
        if (isset($guardian) && isset($dueno)) {
            $this->nombreDueno = $dueno->getNombre();
            $this->dniDueno = $dueno->getDni();
            $this->nombreGuardian = $guardian->getNombre();
            $this->dniGuardian = $guardian->getdni();
            $this->nuevo = true;
            $this->senderUlt = $senderUlt;
        }
    }

    public function getIdC()
    {
        return $this->idC;
    }

    public function setIdC($idC): self
    {
        $this->idC = $idC;

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

    public function getNuevo()
    {
        return $this->nuevo;
    }

    public function setNuevo($nuevo): self
    {
        $this->nuevo = $nuevo;

        return $this;
    }

    public function getSenderUlt()
    {
        return $this->senderUlt;
    }

    public function setSenderUlt($senderUlt): self
    {
        $this->senderUlt = $senderUlt;

        return $this;
    }
}
