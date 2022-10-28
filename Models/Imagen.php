<?php namespace Models;

class Imagen
{
    private $id;
    private $idMascota;
    private $nombre;
    /*private $peso;
    private $formato;
    private $extension;
    private $url;*/

    
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
/*
    public function getPeso()
    {
        return $this->peso;
    }

    public function setPeso($peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getFormato()
    {
        return $this->formato;
    }

    public function setFormato($formato): self
    {
        $this->formato = $formato;

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

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url): self
    {
        $this->url = $url;

        return $this;
    }*/

    /**
     * Get the value of idMascota
     */
    public function getIdMascota()
    {
        return $this->idMascota;
    }

    /**
     * Set the value of idMascota
     */
    public function setIdMascota($idMascota): self
    {
        $this->idMascota = $idMascota;

        return $this;
    }
}
