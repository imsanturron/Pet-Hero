<?php

namespace Models;

class Video
{
    private $id;
    private $nombre;
    /*private $peso;
    private $extension;
    private $duracion;*/

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

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
    
    /*public function getPeso()
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
    }*/
}
