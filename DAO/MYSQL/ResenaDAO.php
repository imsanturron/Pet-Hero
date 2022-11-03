<?php

namespace DAO;

use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;
use Models\Resena as Resena;

class ResenaDAO
{
    private $connection;
    private $tableName = "pagos";

    public function Add(Resena $pago)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id, dniDueno, dniGuardian, puntaje, fecha, observacion)
             VALUES (:id, :dniDueno, :dniGuardian, :puntaje, :fecha, :observacion);";

            $parameters["id"] = $pago->getId();
            $parameters["dniDueno"] = $pago->getDniDueno();
            $parameters["dniGuardian"] = $pago->getDniGuardian();
            $parameters["puntaje"] = $pago->getPuntaje();
            $parameters["fecha"] = $pago->getFecha();
            $parameters["observacion"] = $pago->getObservacion();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $resenaList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $resena = new Resena();
                $resena->setId($row["id"]);
                $resena->setDniDueno($row["dniDueno"]);
                $resena->setDniGuardian($row["dniGuardian"]);
                $resena->setPuntaje($row["puntaje"]);
                $resena->setFecha($row["fecha"]);
                $resena->setObservacion($row["observacion"]);
                array_push($resenaList, $resena);
            }
            return $resenaList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $resena = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $resena = new Resena();
                $resena->setId($row["id"]);
                $resena->setDniDueno($row["dniDueno"]);
                $resena->setDniGuardian($row["dniGuardian"]);
                $resena->setPuntaje($row["puntaje"]);
                $resena->setFecha($row["fecha"]);
                $resena->setObservacion($row["observacion"]);
            }

            return $resena;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getResenasByDniGuardian($dniGuardian) /////
    {
        try {
            $resenaList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE dniGuardian = :dniGuardian";

            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $resena = new Resena();
                $resena->setId($row["id"]);
                $resena->setDniDueno($row["dniDueno"]);
                $resena->setDniGuardian($row["dniGuardian"]);
                $resena->setPuntaje($row["puntaje"]);
                $resena->setFecha($row["fecha"]);
                $resena->setObservacion($row["observacion"]);
                array_push($resenaList, $resena);
            }
            if (isset($resenaList))
                return $resenaList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getReservasByDniDueno($dniDueno) /////
    {
        try {
            $resenaList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE dniDueno = :dniDueno";

            $parameters["dniDueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $resena = new Resena();
                $resena->setId($row["id"]);
                $resena->setDniDueno($row["dniDueno"]);
                $resena->setDniGuardian($row["dniGuardian"]);
                $resena->setPuntaje($row["puntaje"]);
                $resena->setFecha($row["fecha"]);
                $resena->setObservacion($row["observacion"]);
                array_push($resenaList, $resena);
            }
            if (isset($resenaList))
                return $resenaList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
