<?php

namespace Models;

class Resena
{
    private $id; //PK   --> id de reserva/solicitud/pago
    private $dniDueno; //FK
    private $dniGuardian; //FK
    private $puntaje; ///del 1 al 10
    private $fecha; ///que se hizo la observacion
    private $observacion; ///comentarios

    public function __construct($id = null, $dniDueno = null, $dniGuardian = null, $puntaje = null, $observacion = "")
    {
        if ($id && $dniDueno && $dniGuardian) {
            $this->setId($id);
            $this->setDniDueno($dniDueno);
            $this->setDniGuardian($dniGuardian);
            $this->setPuntaje($puntaje);
            $this->setFecha(date("Y-m-d"));
            $this->setObservacion($observacion);
        }
    }

    public function getPuntaje()
    {
        return $this->puntaje;
    }

    public function setPuntaje($puntaje): self
    {
        $this->puntaje = $puntaje;

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

    public function getObservacion()
    {
        return $this->observacion;
    }

    public function setObservacion($observacion): self
    {
        $this->observacion = $observacion;

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

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
}
