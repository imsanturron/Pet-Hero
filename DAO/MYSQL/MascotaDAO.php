<?php

namespace DAO\MYSQL;

use Models\Mascota as Mascota;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class MascotaDAO
{
    private $connection;
    private $tableName = "mascotas";
    //private $usuarioList = array();
    //private $filename;

    
    public function Add(Mascota $mascota)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (id, nombre, especie, raza, dueno, idSoliRes, tamano, observaciones)
             VALUES (:id, :nombre, :especie, :raza, :dueno, :idSoliRes, :tamano, :observaciones);";
            
              $parameters["id"] = $mascota->getId();
              $parameters["nombre"] = $mascota->getNombre();
              $parameters["especie"] = $mascota->getEspecie();
              $parameters["raza"] = $mascota->getRaza();
              $parameters["dueno"] = $mascota->getDniDueno();
              $parameters["idSoliRes"] = $mascota->getIdSoliRes();
              $parameters["tamano"] = $mascota->getTamano();
              $parameters["observaciones"] = $mascota->getObservaciones();
              //$parameters["fotoMascota"] = $mascota->getFotoMascota();
              //$parameters["video"] = $mascota->getVideo();
              //$parameters["planVacunacion"] = $mascota->getPlanVacunacion();
              ///
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function GetAll()
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
                    $mascota->setId($row["id"]);
                    $mascota->setNombre($row["nombre"]);
                    $mascota->setRaza($row["raza"]);
                    $mascota->setEspecie($row["especie"]);
                    $mascota->setDniDueno($row["dueno"]);
                    $mascota->setIdSoliRes($row["idSoliRes"]);
                    $mascota->setTamano($row["tamano"]);
                    $mascota->setObservaciones($row["observaciones"]);
                    //$mascota->setFotoMascota($row["fotoMascota"]);
                    //$mascota->setVideo($row["video"]);
                    //$mascota->setPlanVacunacion($row["planVacunacion"]);
                    array_push($mascotaList, $mascota);
                }
                return $mascotaList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }

        function getArrayByIds($ids) /////
        {
          try {
            $mascotaList = array();
      
            foreach($ids as $id){
            $query = "SELECT * FROM " . $this->tableName . " WHERE id = :id";
      
            $parameters["id"] = $id;
      
            $this->connection = Connection::GetInstance();
      
            $resultSet = $this->connection->Execute($query, $parameters);
      
            foreach ($resultSet as $row) {
                $mascota = new Mascota();
                $mascota->setId($row["id"]);
                $mascota->setNombre($row["nombre"]);
                $mascota->setRaza($row["raza"]);
                $mascota->setEspecie($row["especie"]);
                $mascota->setDniDueno($row["dueno"]);
                $mascota->setIdSoliRes($row["idSoliRes"]);
                $mascota->setTamano($row["tamano"]);
                $mascota->setObservaciones($row["observaciones"]);
                array_push($mascotaList, $mascota);
              ////////
            }
        }
      
            return $mascotaList;
          } catch (Exception $ex) {
            throw $ex;
          }
        }

        function setIdSolicitudEnMascota($mascotas,$idSolicitud) /////
        {
          try {
            
      
            foreach($mascotas as $mascota){
                $query = "UPDATE " . $this->tableName . " SET idSoliRes = :idSoliRes WHERE id = :id;";
      
                $parameters["idSoliRes"] = $idSolicitud;
                $parameters["id"] = $mascota->getId();
          

            $this->connection = Connection::GetInstance();
      
            $resultSet = $this->connection->Execute($query, $parameters);
      
            foreach ($resultSet as $row) {
                $mascota = new Mascota();
                $mascota->setId($row["id"]);
                $mascota->setNombre($row["nombre"]);
                $mascota->setRaza($row["raza"]);
                $mascota->setEspecie($row["especie"]);
                $mascota->setDniDueno($row["dueno"]);
                $mascota->setIdSoliRes($row["idSoliRes"]);
                $mascota->setTamano($row["tamano"]);
                $mascota->setObservaciones($row["observaciones"]);
             
              ////////

            }
        }
           
      
          } catch (Exception $ex) {
            throw $ex;
          }
        }


/*
        function getMascotasByIdSolicitud($) /////
        {
          try {
            $solicitudList = array();
      
           
            $query = "SELECT * FROM " . $this->tableName . " WHERE dniGuardian = :dniGuardian";
      
            $parameters["dniGuardian"] = $dniGuardian;
      
            $this->connection = Connection::GetInstance();
      
            $resultSet = $this->connection->Execute($query, $parameters);
      
            foreach ($resultSet as $row) {
                $solicitud = new Solicitud();
                $solicitud->setId($row["id"]);
                //$solicitud->setAnimales($row["animales"]);
                $solicitud->setFechaInicio($row["FechaInicio"]);
                $solicitud->setFechaFin($row["FechaFin"]);
                $solicitud->setNombreDueno($row["nombreDueno"]);
                $solicitud->setDniDueno($row["dniDueno"]);
                $solicitud->setNombreGuardian($row["nombreGuardian"]);
                $solicitud->setDniGuardian($row["dniGuardian"]);
                $solicitud->setDireccionGuardian($row["direccionGuardian"]);
                $solicitud->setTelefonoDueno($row["telefonoDueno"]);
                $solicitud->setTelefonoGuardian($row["telefonoGuardian"]);
                array_push($solicitudList, $solicitud);
              ////////
            }
        
      
            return $solicitudList;
          } catch (Exception $ex) {
            throw $ex;
          }
        }
  */

    /*public function __construct()
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
    /*public function search(Mascota $user)
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
    }*/
}