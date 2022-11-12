<?php

namespace DAO\MYSQL;

use Models\Guardian as Guardian;
use Models\Solicitud as Solicitud;
use Models\Reserva as Reserva;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class SolicitudDAO
{
    private $connection;
    private $tableName = "solicitudes";

    public function Add(Solicitud $solicitud)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (FechaInicio, FechaFin, dniDueno, dniGuardian, esPago)
             VALUES ( :FechaInicio, :FechaFin, :dniDueno, :dniGuardian, :esPago);";

            $parameters["FechaInicio"] = $solicitud->getFechaInicio();
            $parameters["FechaFin"] = $solicitud->getFechaFin();
            $parameters["dniDueno"] = $solicitud->getDniDueno();
            $parameters["dniGuardian"] = $solicitud->getDniGuardian();
            $parameters["esPago"] = false;
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $solicitudList = array();
            $query = "SELECT s.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,  d.telefono as telefonoDueno, g.direccion as direccionGuardian, g.telefono as telefonoGuardian
              FROM " . $this->tableName . " s join duenos d on s.dniDueno = d.dni join guardianes g on s.dniGuardian = g.dni";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $solicitud = new Solicitud();
                $solicitud->setId($row["id"]);
                $solicitud->setFechaInicio($row["FechaInicio"]);
                $solicitud->setFechaFin($row["FechaFin"]);
                $solicitud->setNombreDueno($row["nombreDueno"]);
                $solicitud->setDniDueno($row["dniDueno"]);
                $solicitud->setNombreGuardian($row["nombreGuardian"]);
                $solicitud->setDniGuardian($row["dniGuardian"]); ///ACA VA EL ALIAS EN ""
                $solicitud->setDireccionGuardian($row["direccionGuardian"]);
                $solicitud->setTelefonoDueno($row["telefonoDueno"]);
                $solicitud->setTelefonoGuardian($row["telefonoGuardian"]);
                $solicitud->setEsPago($row["esPago"]);
                array_push($solicitudList, $solicitud);
            }
            return $solicitudList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $solicitud = null;

            $query = "SELECT s.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,  d.telefono as telefonoDueno, g.direccion as direccionGuardian, g.telefono as telefonoGuardian
             FROM " . $this->tableName . " s join duenos d on s.dniDueno = d.dni join guardianes g on s.dniGuardian = g.dni WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $solicitud = new Solicitud();
                $solicitud->setId($row["id"]);
                $solicitud->setFechaInicio($row["FechaInicio"]);
                $solicitud->setFechaFin($row["FechaFin"]);
                $solicitud->setNombreDueno($row["nombreDueno"]);
                $solicitud->setDniDueno($row["dniDueno"]);
                $solicitud->setNombreGuardian($row["nombreGuardian"]);
                $solicitud->setDniGuardian($row["dniGuardian"]);
                $solicitud->setDireccionGuardian($row["direccionGuardian"]);
                $solicitud->setTelefonoDueno($row["telefonoDueno"]);
                $solicitud->setTelefonoGuardian($row["telefonoGuardian"]);
                $solicitud->setEsPago($row["esPago"]);
            }

            return $solicitud;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetIdByDniDuenoYGuardian($dniDueno, $dniGuardian)
    {
        try {
            $solicitud = null;

            $query = "SELECT id FROM " . $this->tableName . " WHERE dniDueno = :dniDueno AND dniGuardian = :dniGuardian";


            $parameters["dniDueno"] = $dniDueno;
            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $solicitud = new Solicitud();
                $solicitud->setId($row["id"]);
            }

            return $solicitud->getId();
        } catch (Exception $ex) {
            throw $ex;
        }
    }



    function getSolicitudesByDniGuardian($dniGuardian) /////
    {
        try {
            $solicitudList = array();


            $query = "SELECT s.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,  d.telefono as telefonoDueno, g.direccion as direccionGuardian, g.telefono as telefonoGuardian 
            FROM " . $this->tableName . " s join duenos d on s.dniDueno = d.dni join guardianes g on s.dniGuardian = g.dni WHERE dniGuardian = :dniGuardian";

            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $solicitud = new Solicitud();
                $solicitud->setId($row["id"]);
                $solicitud->setFechaInicio($row["FechaInicio"]);
                $solicitud->setFechaFin($row["FechaFin"]);
                $solicitud->setNombreDueno($row["nombreDueno"]);
                $solicitud->setDniDueno($row["dniDueno"]);
                $solicitud->setNombreGuardian($row["nombreGuardian"]);
                $solicitud->setDniGuardian($row["dniGuardian"]);
                $solicitud->setDireccionGuardian($row["direccionGuardian"]);
                $solicitud->setTelefonoDueno($row["telefonoDueno"]);
                $solicitud->setTelefonoGuardian($row["telefonoGuardian"]);
                $solicitud->setEsPago($row["esPago"]);
                array_push($solicitudList, $solicitud);
            }
            if (isset($solicitudList))
                return $solicitudList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getSolicitudesByDniDueno($dniDueno) /////
    {
        try {
            $solicitudList = array();


            $query = "SELECT s.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,  d.telefono as telefonoDueno, g.direccion as direccionGuardian, g.telefono as telefonoGuardian 
            FROM " . $this->tableName . " s join duenos d on s.dniDueno = d.dni join guardianes g on s.dniGuardian = g.dni WHERE dniDueno = :dniDueno";

            $parameters["dniDueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $solicitud = new Solicitud();
                $solicitud->setId($row["id"]);
                $solicitud->setFechaInicio($row["FechaInicio"]);
                $solicitud->setFechaFin($row["FechaFin"]);
                $solicitud->setNombreDueno($row["nombreDueno"]);
                $solicitud->setDniDueno($row["dniDueno"]);
                $solicitud->setNombreGuardian($row["nombreGuardian"]);
                $solicitud->setDniGuardian($row["dniGuardian"]);
                $solicitud->setDireccionGuardian($row["direccionGuardian"]);
                $solicitud->setTelefonoDueno($row["telefonoDueno"]);
                $solicitud->setTelefonoGuardian($row["telefonoGuardian"]);
                $solicitud->setEsPago($row["esPago"]);
                array_push($solicitudList, $solicitud);
            }
            if (isset($solicitudList))
                return $solicitudList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function updateAPagoById($id){
        try {
            $query = "UPDATE " . $this->tableName . " SET esPago = :esPago WHERE id = :id;";

            $parameters["esPago"] = true;
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            return false;
            //throw $ex;
        }
    }

    
    public function removeSolicitudById($idSolicitud)
    {

        try {
            $solicitud = null;

            $query = "DELETE FROM " . $this->tableName . " WHERE id = :id";

            $parameters["id"] = $idSolicitud;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);


            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function removeSolicitudesByDniDueno($dniDueno)
    {

        try {
            $solicitud = null;

            $query = "DELETE FROM " . $this->tableName . " WHERE dniDueno = :dniDueno";

            $parameters["dniDueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);


            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function removeSolicitudesByDniGuardian($dniGuardian)
    {

        try {
            $solicitud = null;

            $query = "DELETE FROM " . $this->tableName . " WHERE dniGuardian = :dniGuardian";

            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);


            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////FUNCIONES JSONJSONJSON/////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*public function __construct()
    {
        $this->filename = dirname(__DIR__) . "\Data\Solicitud" . ".json";
    }
    public function add(Solicitud $user)
    {
        $this->retrieveData();
        array_push($this->usuarioList, $user);
        $this->saveData();
    }
    public function remove(Solicitud $user)
    {
        $this->retrieveData();
        if (($clave = array_search($user, $this->usuarioList)) !== false) {
            unset($this->usuarioList[$clave]);
        }
        $this->SaveData();
    }
    public function getByUsername($user)
    {
        $this->retrieveData();
        foreach ($this->usuarioList as $item) {
            if ($item->getUsername() == $user)
                return $item;
        }
        return null;
    }
    public function getByDni($dni)
    {
        $this->retrieveData();
        foreach ($this->usuarioList as $item) {
            if ($item->getDni() == $dni)
                return $item;
        }
        return null;
    }
    public function addSolicitudDao(Solicitud $solicitud, $dni)
    {
        $this->retrieveData();
        foreach ($this->usuarioList as $item) {
            if ($item->getDni() == $dni) {
                $item->addSolicitud($solicitud);
                $this->SaveData();
                return true;
            }
        }
        return false;
    }
    /**BUsca factura por numero y tipo  en archivo retorna true o false */
    /*public function search(Solicitud $user)
    {
        $this->retrieveData();
        $encontrado = false;
        foreach ($this->usuarioList as $element) {
            if (/*$user->getUsername() == $element->getUsername()*//*true) {
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
        foreach ($this->usuarioList as $solicitud) {
            $valueArray["id"] = $solicitud->getId();
            $valueArray["animales"] = $solicitud->getAnimales();
            $valueArray["fechaInicio"] = $solicitud->getFechaInicio();
            $valueArray["fechaFin"] = $solicitud->getFechaFin();
            $valueArray["nombreDueno"] = $solicitud->getNombreDueno();
            $valueArray["dniDueno"] = $solicitud->getDniDueno();
            $valueArray["nombreGuardian"] = $solicitud->getNombreGuardian();
            $valueArray["dniGuardian"] = $solicitud->getDniGuardian();
            $valueArray["direccion"] = $solicitud->getDireccion();
            ///etc
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
                $solicitud = new Solicitud();
                $solicitud->setId($valueArray["id"]);
                $solicitud->setAnimales($valueArray["animales"]);
                $solicitud->setFechaInicio($valueArray["FechaInicio"]);
                $solicitud->setFechaFin($valueArray["FechaFin"]);
                $solicitud->setNombreDueno($valueArray["nombreDueno"]);
                $solicitud->setDniDueno($valueArray["dniDueno"]);
                $solicitud->setNombreGuardian($valueArray["nombreGuardian"]);
                $solicitud->setDniGuardian($valueArray["dniGuardian"]);
                $solicitud->setDireccion($valueArray["direccion"]);
                array_push($this->usuarioList, $solicitud);
            }
        }
    }
    public function getUsuarioList()
    {
        return $this->usuarioList;
    }*/
}
