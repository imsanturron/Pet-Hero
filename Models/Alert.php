<?php

namespace Models;

class Alert
{
    private $tipo;
    private $mensaje;

    public function __construct($tipo = "", $mensaje = "")
    {
        $this->tipo = $tipo;
        $this->mensaje = $mensaje;
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

    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function setMensaje($mensaje): self
    {
        $this->mensaje = $mensaje;

        return $this;
    }
}
