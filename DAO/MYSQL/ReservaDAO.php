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
            $reserva = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id = :id";

            $parameters["id"] = $id;

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
            }

            return $reserva;
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

    function updateEstado($id, $nuevoEstado){
        try {
            $query = "UPDATE " . $this->tableName . " SET estado = :estado WHERE id = :id;";

            $parameters["estado"] = $nuevoEstado;
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            return false;
            //throw $ex;
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////FUNCIONES JSONJSONJSON/////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*
    public function remove(Reserva $user)
    {
        $this->retrieveData();

        if (($clave = array_search($user, $this->usuarioList)) !== false) {

            unset($this->usuarioList[$clave]);
        }

        $this->SaveData();
    }

*/
}
