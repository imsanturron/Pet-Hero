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

            $solicitudList = $this->setter($resultSet, true);

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

            $solicitud = $this->setter($resultSet);

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

            $solicitudList = $this->setter($resultSet, true);

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

            $solicitudList = $this->setter($resultSet, true);
            
            if (isset($solicitudList))
                return $solicitudList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function updateAPagoById($id)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET esPago = :esPago WHERE id = :id;";

            $parameters["esPago"] = true;
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            throw $ex;
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
            $query = "DELETE FROM " . $this->tableName . " WHERE dniGuardian = :dniGuardian";

            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function setter($resultSet, $list = false)
    {
        $lista = array();

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
            if ($list == true)
                array_push($lista, $solicitud);
        }
        if ($list == true)
            return $lista;
        else
            return $solicitud;
    }
}
