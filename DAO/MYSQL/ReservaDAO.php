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

    public function Add(Reserva $reserva)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id, FechaInicio, FechaFin, dniDueno, dniGuardian, estado, crearResena, hechaOrechazada)
             VALUES (:id, :FechaInicio, :FechaFin, :dniDueno, :dniGuardian, :estado, :crearResena, :hechaOrechazada);";

            $parameters["id"] = $reserva->getId();
            $parameters["FechaInicio"] = $reserva->getFechaInicio();
            $parameters["FechaFin"] = $reserva->getFechaFin();
            $parameters["dniDueno"] = $reserva->getDniDueno();
            $parameters["dniGuardian"] = $reserva->getDniGuardian();
            $parameters["estado"] = $reserva->getEstado();
            $parameters["crearResena"] = $reserva->getCrearResena();
            $parameters["hechaOrechazada"] = $reserva->getResHechaOrechazada();
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
            $query = "SELECT r.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,  d.telefono as telefonoDueno, g.direccion as direccionGuardian, g.telefono as telefonoGuardian
             FROM " . $this->tableName . " r join duenos d on r.dniDueno = d.dni join guardianes g on r.dniGuardian = g.dni";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            $reservaList = $this->setter($resultSet, true);

            return $reservaList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $reserva = null;
            $query = "SELECT r.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,  d.telefono as telefonoDueno, g.direccion as direccionGuardian, g.telefono as telefonoGuardian
             FROM " . $this->tableName . " r join duenos d on r.dniDueno = d.dni join guardianes g on r.dniGuardian = g.dni WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $reserva = $this->setter($resultSet);

            return $reserva;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getReservasByDniGuardian($dniGuardian)
    {
        try {
            $reservaList = array();

            $query = "SELECT r.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,  d.telefono as telefonoDueno, g.direccion as direccionGuardian, g.telefono as telefonoGuardian 
            FROM " . $this->tableName . " r join duenos d on r.dniDueno = d.dni join guardianes g on r.dniGuardian = g.dni WHERE dniGuardian = :dniGuardian";

            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $reservaList = $this->setter($resultSet, true);

            if (isset($reservaList))
                return $reservaList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getReservasByDniDueno($dniDueno)
    {
        try {
            $reservaList = array();

            $query = "SELECT r.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,  d.telefono as telefonoDueno, g.direccion as direccionGuardian, g.telefono as telefonoGuardian 
            FROM " . $this->tableName . " r join duenos d on r.dniDueno = d.dni join guardianes g on r.dniGuardian = g.dni WHERE dniDueno = :dniDueno";

            $parameters["dniDueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $reservaList = $this->setter($resultSet, true);

            if (isset($reservaList))
                return $reservaList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function updateEstado($id, $nuevoEstado)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET estado = :estado WHERE id = :id;";

            $parameters["estado"] = $nuevoEstado;
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function updateCrearResena($id, $nuevoEstado)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET crearResena = :crearResena WHERE id = :id;";

            $parameters["crearResena"] = $nuevoEstado;
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function updateResHechaOrechazada($id, $nuevoEstado)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET hechaOrechazada = :hechaOrechazada WHERE id = :id;";

            $parameters["hechaOrechazada"] = $nuevoEstado;
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function setter($resultSet, $list = false)
    {
        $lista = array();

        foreach ($resultSet as $row) {
            $reserva = new Reserva();
            $reserva->setId($row["id"]);
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
            $reserva->setCrearResena($row["crearResena"]);
            $reserva->setResHechaOrechazada($row["hechaOrechazada"]);
            if ($list == true)
                array_push($lista, $reserva);
        }
        if ($list == true)
            return $lista;
        else
            return $reserva;
    }
}
