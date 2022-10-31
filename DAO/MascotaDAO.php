<?php namespace DAO;

use Models\Mascota as Mascota;
class MascotaDAO
{
    private $usuarioList = array();
    private $filename;

    public function __construct()
    {
        $this->filename = dirname(__DIR__) . "\Data\Mascota" . ".json";
    }

    public function add(Mascota $user)
    {
        $this->retrieveData();
        array_push($this->usuarioList, $user);
        $this->SaveData();
    }


    public function remove(Mascota $user)
    {
        $this->retrieveData();

        if (($clave = array_search($user, $this->usuarioList)) !== false) {

            unset($this->usuarioList[$clave]);
        }

        $this->SaveData();
    }
    /**BUsca factura por numero y tipo  en archivo retorna true o false */
    public function search(Mascota $user)
    {
        $this->retrieveData();
        $encontrado = false;

        foreach ($this->usuarioList as $element) {

            if ($user->getUsername == $element->getUsername()) {

                $encontrado = true;
            }
        }
        return $encontrado;
    }

    public function getAll()
    {
        $this->retrieveData();
        return $this->usuarioList;
    }

    public function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->usuarioList as $mascota) {

            $valueArray["nombre"] = $mascota->getNombre();
            $valueArray["raza"] = $mascota->getRaza();
            $valueArray["dueno"] = $mascota->getDniDueno();
            $valueArray["tamaño"] = $mascota->getTamano();
            $valueArray["observaciones"] = $mascota->getObservaciones();
            array_push($arrayToEncode, $valueArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $jsonContent);
    }

    private function retrieveData()
    {
        $this->usuarioList = array();

        if (file_exists($this->filename)) {

            $jsonContent = file_get_contents($this->filename);
            $arrayToEncode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToEncode as $valueArray) {

                $usuario = new Mascota;
                $usuario->setNombre($valueArray["nombre"]);
                $usuario->setRaza($valueArray["raza"]);
                $usuario->setDniDueno($valueArray["dueno"]);
                $usuario->setTamano($valueArray["tamaño"]);
                $usuario->setObservaciones($valueArray["observaciones"]);
                array_push($this->usuarioList, $usuario);
            }
        }
    }

    public function getUsuarioList()
    {
        return $this->usuarioList;
    }
}