<?php

namespace DAO\MYSQL;

use Models\Guardian as Guardian;
use Models\Solicitud as Solicitud;
use Models\Reserva as Reserva;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class ReservaDAO
{
    private $connection;
    private $tableName = "reservas";
    //private $usuarioList = array();
    //private $filename;

    public function Add(Reserva $reserva)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id, FechaInicio, FechaFin, nombreDueno, dniDueno, nombreGuardian, dniGuardian, direccionGuardian, telefonoDueno, telefonoGuardian, estado)
             VALUES (:id, :FechaInicio, :FechaFin, :nombreDueno, :dniDueno, :nombreGuardian, :dniGuardian, :direccionGuardian, :telefonoDueno, :telefonoGuardian, :estado);";

            $parameters["id"] = $reserva->getId();
            //$parameters["animales"] = $reserva->getAnimales();
            $parameters["FechaInicio"] = $reserva->getFechaInicio();
            $parameters["FechaFin"] = $reserva->getFechaFin();
            $parameters["nombreDueno"] = $reserva->getNombreDueno();
            $parameters["dniDueno"] = $reserva->getDniDueno();
            $parameters["nombreGuardian"] = $reserva->getNombreGuardian();
            $parameters["dniGuardian"] = $reserva->getDniGuardian();
            $parameters["direccionGuardian"] = $reserva->getDireccionGuardian();
            $parameters["telefonoDueno"] = $reserva->getTelefonoDueno();
            $parameters["telefonoGuardian"] = $reserva->getTelefonoGuardian();
            $parameters["estado"] = $reserva->getEstado();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $reservaList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $reserva = new Reserva();
                $reserva->setId($row["id"]);
                //$reserva->setAnimales($row["animales"]);
                $reserva->setFechaInicio($row["FechaInicio"]);
                $reserva->setFechaFin($row["FechaFin"]);
                $reserva->setNombreDueno($row["nombreDueno"]);
                $reserva->setDniDueno($row["dniDueno"]);
                $reserva->setNombreGuardian($row["nombreGuardian"]);
                $reserva->setDniGuardian($row["dniGuardian"]);
                $reserva->setDireccionGuardian($row["direccionGuardian"]);
                $reserva->setTelefonoDueno($row["telefonoDueno"]);
                $reserva->setTelefonoGuardian($row["telefonoGuardian"]);
                $reserva->setEstado($row["estado"]);
                array_push($reservaList, $reserva);
            }
            return $reservaList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $solicitud = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $solicitud = new Guardian();
                $solicitud->setDni($row["dni"]);
                $solicitud->setNombre($row["nombre"]);
                ////////
            }

            return $solicitud;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getReservasByDniGuardian($dniGuardian) /////
    {
        try {
            $reservaList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE dniGuardian = :dniGuardian";

            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $reserva = new Reserva();
                $reserva->setId($row["id"]);
                //$reserva->setAnimales($row["animales"]);
                $reserva->setFechaInicio($row["FechaInicio"]);
                $reserva->setFechaFin($row["FechaFin"]);
                $reserva->setNombreDueno($row["nombreDueno"]);
                $reserva->setDniDueno($row["dniDueno"]);
                $reserva->setNombreGuardian($row["nombreGuardian"]);
                $reserva->setDniGuardian($row["dniGuardian"]);
                $reserva->setDireccionGuardian($row["direccionGuardian"]);
                $reserva->setTelefonoDueno($row["telefonoDueno"]);
                $reserva->setTelefonoGuardian($row["telefonoGuardian"]);
                $reserva->setEstado($row["estado"]);
                array_push($reservaList, $reserva);
            }
            if (isset($reservaList))
                return $reservaList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getReservasByDniDueno($dniDueno) /////
    {
        try {
            $reservaList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE dniDueno = :dniDueno";

            $parameters["dniDueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $reserva = new Reserva();
                $reserva->setId($row["id"]);
                //$reserva->setAnimales($row["animales"]);
                $reserva->setFechaInicio($row["FechaInicio"]);
                $reserva->setFechaFin($row["FechaFin"]);
                $reserva->setNombreDueno($row["nombreDueno"]);
                $reserva->setDniDueno($row["dniDueno"]);
                $reserva->setNombreGuardian($row["nombreGuardian"]);
                $reserva->setDniGuardian($row["dniGuardian"]);
                $reserva->setDireccionGuardian($row["direccionGuardian"]);
                $reserva->setTelefonoDueno($row["telefonoDueno"]);
                $reserva->setTelefonoGuardian($row["telefonoGuardian"]);
                $reserva->setEstado($row["estado"]);
                array_push($reservaList, $reserva);
            }
            if (isset($reservaList))
                return $reservaList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////FUNCIONES JSONJSONJSON/////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*public function __construct()
    {
        $this->filename = dirname(__DIR__) . "\Data\Reserva" . ".json";
    }

    public function add(Reserva $user)
    {
        $this->retrieveData();
        array_push($this->usuarioList, $user);
        $this->saveData();
    }


    public function remove(Reserva $user)
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

    public function addSolicitudDao(Reserva $solicitud, $dni)
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
    /*public function search(Reserva $user)
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
            $valueArray["estado"] = $solicitud->getEstado();
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

                $solicitud = new Reserva();
                $solicitud->setId($valueArray["id"]);
                $solicitud->setAnimales($valueArray["animales"]);
                $solicitud->setFechaInicio($valueArray["FechaInicio"]);
                $solicitud->setFechaFin($valueArray["FechaFin"]);
                $solicitud->setNombreDueno($valueArray["nombreDueno"]);
                $solicitud->setDniDueno($valueArray["dniDueno"]);
                $solicitud->setNombreGuardian($valueArray["nombreGuardian"]);
                $solicitud->setDniGuardian($valueArray["dniGuardian"]);
                $solicitud->setDireccion($valueArray["direccion"]);
                $solicitud->setEstado($valueArray["estado"]);
                array_push($this->usuarioList, $solicitud);
            }
        }
    }

    public function getUsuarioList()
    {
        return $this->usuarioList;
    }*/
}
