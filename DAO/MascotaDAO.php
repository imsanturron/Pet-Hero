<?php

namespace DAO;

use Models\Mascota as Mascota;
use DAO\Connection as Connection;
use \Exception as Exception;

class MascotaDAO
{
    //private $connection;
    //private $tableName = "students";
    private $usuarioList = array();
    private $filename;

    public function __construct()
    {
        $this->filename = dirname(__DIR__) . "\Data\Mascota" . ".json";
    }

    public function add(Mascota $user)
    {
        $this->retrieveData();
        $user->setId($this->GetNextId());
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

    public function getArrayByIds($ids)
    {
        $retArray = array();
        $this->retrieveData();
        foreach ($ids as $id) {
            foreach ($this->usuarioList as $item) {
                if ($item->getId() == $id)
                    array_push($retArray, $item);
            }
        }
        if (isset($retArray) && !empty($retArray))
            return $retArray;
        else
            return null;
    }

    public function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->usuarioList as $mascota) {

            $valueArray["id"] = $mascota->getId();
            $valueArray["especie"] = $mascota->getEspecie();
            $valueArray["nombre"] = $mascota->getNombre();
            $valueArray["raza"] = $mascota->getRaza();
            $valueArray["dueno"] = $mascota->getDniDueno();
            $valueArray["tamano"] = $mascota->getTamano();
            $valueArray["observaciones"] = $mascota->getObservaciones();
            //$valueArray["fotoMascota"] = $mascota->getFotoMascota();
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
                $usuario->setId($valueArray["id"]);
                $usuario->setEspecie($valueArray["especie"]);
                $usuario->setNombre($valueArray["nombre"]);
                $usuario->setRaza($valueArray["raza"]);
                $usuario->setDniDueno($valueArray["dueno"]);
                $usuario->setTamano($valueArray["tamano"]);
                $usuario->setObservaciones($valueArray["observaciones"]);
                //$usuario->setFotoMascota($valueArray["fotoMascota"]);
                array_push($this->usuarioList, $usuario);
            }
        }
    }

    public function getUsuarioList()
    {
        return $this->usuarioList;
    }

    private function GetNextId()
    {
        $id = 0;

        foreach($this->usuarioList as $mascota)
        {
            $id = ($mascota->getId() > $id) ? $mascota->getId() : $id;
        }

        return $id + 1;
    }

    /*public function Add(Dueno $dueno)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (nombre, raza, dueno, tamano, observaciones, fotoMascota)
             VALUES (:nombre, :raza, :dueno, :tamano, :observaciones, :fotoMascota);";
            
              $parameters["nombre"] = $dueno->getNombre();
              $parameters["raza"] = $dueno->getRaza();
              $parameters["dueno"] = $dueno->getDniDueno();
              $parameters["tamano"] = $dueno->getTamano();
              $parameters["observaciones"] = $dueno->getObservaciones();
              $parameters["fotoMascota"] = $dueno->getFotoMascota();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }*/

    /*public function GetAll()
        {
            try
            {
                $mascotaList = array();
                $query = "SELECT * FROM ".$this->tableName;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $mascota = new Mascota();
                    $mascota->setNombre($valueArray["nombre"]);
                    $mascota->setRaza($valueArray["raza"]);
                    $mascota->setDniDueno($valueArray["dueno"]);
                    $mascota->setTamano($valueArray["tamano"]);
                    $mascota->setObservaciones($valueArray["observaciones"]);
                    $mascota->setFotoMascota($valueArray["fotoMascota"]);
                    array_push($mascotaList, $mascota);
                }
                return $mascotaList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }*/
}
