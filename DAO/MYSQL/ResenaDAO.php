<?php

namespace DAO\MYSQL;

use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;
use Models\Resena as Resena;

class ResenaDAO
{
    private $connection;
    private $tableName = "resenas";

    public function Add(Resena $resena)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id, dniDueno, dniGuardian, puntaje, fecha, observaciones)
             VALUES (:id, :dniDueno, :dniGuardian, :puntaje, :fecha, :observaciones);";

            $parameters["id"] = $resena->getId();
            $parameters["dniDueno"] = $resena->getDniDueno();
            $parameters["dniGuardian"] = $resena->getDniGuardian();
            $parameters["puntaje"] = $resena->getPuntaje();
            $parameters["fecha"] = $resena->getFecha();
            $parameters["observaciones"] = $resena->getObservacion();
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

            $resenaList = $this->setter($resultSet, true);

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

            $resena = $this->setter($resultSet);

            return $resena;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getResenasByDniGuardian($dniGuardian)
    {
        try {
            $resenaList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE dniGuardian = :dniGuardian";

            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $resenaList = $this->setter($resultSet, true);

            if (isset($resenaList))
                return $resenaList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getResenasByDniDueno($dniDueno)
    {
        try {
            $resenaList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE dniDueno = :dniDueno";

            $parameters["dniDueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $resenaList = $this->setter($resultSet, true);

            if (isset($resenaList))
                return $resenaList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function setter($resultSet, $list = false)
    {
        $lista = array();

        foreach ($resultSet as $row) {
            $resena = new Resena();
            $resena->setId($row["id"]);
            $resena->setDniDueno($row["dniDueno"]);
            $resena->setDniGuardian($row["dniGuardian"]);
            $resena->setPuntaje($row["puntaje"]);
            $resena->setFecha($row["fecha"]);
            $resena->setObservacion($row["observaciones"]);
            if ($list == true)
                array_push($lista, $resena);
        }
        if ($list == true)
            return $lista;
        else
            return $resena;
    }
}
