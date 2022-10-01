<?php

namespace Models;

class Video
{
    private $peso;
    private $extension;
    private $duracion;

    public function getPeso()
    {
        return $this->peso;
    }

    public function setPeso($peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getDuracion()
    {
        return $this->duracion;
    }

    public function setDuracion($duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }
}
