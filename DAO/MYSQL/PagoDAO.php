<?php

namespace DAO;

use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;
use Models\Pago as Pago;

class PagoDAO
{
    private $connection;
    private $tableName = "pagos";

    public function Add(Pago $pago)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id, dniDueno, dniGuardian, monto, fecha, formaDePago)
             VALUES (:id, :dniDueno, :dniGuardian, :monto, :fecha, :formaDePago);";

            $parameters["id"] = $pago->getId();
            $parameters["dniDueno"] = $pago->getDniDueno();
            $parameters["dniGuardian"] = $pago->getDniGuardian();
            $parameters["monto"] = $pago->getMonto();
            $parameters["fecha"] = $pago->getFecha();
            $parameters["formaDePago"] = $pago->getFormaDePago();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $pagoList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $pago = new Pago();
                $pago->setId($row["id"]);
                $pago->setDniDueno($row["dniDueno"]);
                $pago->setDniGuardian($row["dniGuardian"]);
                $pago->setMonto($row["monto"]);
                $pago->setFecha($row["fecha"]);
                $pago->setFormaDePago($row["formaDePago"]);
                array_push($pagoList, $pago);
            }
            return $pagoList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $pago = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $pago = new Pago();
                $pago->setId($row["id"]);
                $pago->setDniDueno($row["dniDueno"]);
                $pago->setDniGuardian($row["dniGuardian"]);
                $pago->setMonto($row["monto"]);
                $pago->setFecha($row["fecha"]);
                $pago->setFormaDePago($row["formaDePago"]);
                ////////
            }

            return $pago;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getPagosByDniGuardian($dniGuardian) /////
    {
        try {
            $pagoList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE dniGuardian = :dniGuardian";

            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $pago = new Pago();
                $pago->setId($row["id"]);
                $pago->setDniDueno($row["dniDueno"]);
                $pago->setDniGuardian($row["dniGuardian"]);
                $pago->setMonto($row["monto"]);
                $pago->setFecha($row["fecha"]);
                $pago->setFormaDePago($row["formaDePago"]);
                array_push($pagoList, $pago);
            }
            if (isset($pagoList))
                return $pagoList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getPagosByDniDueno($dniDueno) /////
    {
        try {
            $pagoList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE dniDueno = :dniDueno";

            $parameters["dniDueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $pago = new Pago();
                $pago->setId($row["id"]);
                $pago->setDniDueno($row["dniDueno"]);
                $pago->setDniGuardian($row["dniGuardian"]);
                $pago->setMonto($row["monto"]);
                $pago->setFecha($row["fecha"]);
                $pago->setFormaDePago($row["formaDePago"]);
                array_push($pagoList, $pago);
            }
            if (isset($pagoList))
                return $pagoList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
