<?php

namespace DAO\MYSQL;

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
            $query = "INSERT INTO " . $this->tableName . " (id, dniDueno, dniGuardian, montoAPagar,primerPagoReserva, pagoFinal, formaDePago)
             VALUES (:id, :dniDueno, :dniGuardian, :montoAPagar, :primerPagoReserva, :pagoFinal, :formaDePago);";

            $parameters["id"] = $pago->getId();
            $parameters["dniDueno"] = $pago->getDniDueno();
            $parameters["dniGuardian"] = $pago->getDniGuardian();
            $parameters["montoAPagar"] = $pago->getMontoAPagar();
            $parameters["primerPagoReserva"] = $pago->getPrimerPagoReserva();
            $parameters["pagoFinal"] = $pago->getPagoFinal();
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
                $pago->setMontoAPagar($row["montoAPagar"]);
                $pago->setPrimerPagoReserva($row["primerPagoReserva"]);
                $pago->setPagoFinal($row["pagoFinal"]);
                $pago->setFormaDePago($row["formaDePago"]);
                $pago->setPrecioGuardian(($pago->getMontoAPagar() * 2));
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
                $pago->setMontoAPagar($row["montoAPagar"]);
                $pago->setPrimerPagoReserva($row["primerPagoReserva"]);
                $pago->setPagoFinal($row["pagoFinal"]);
                $pago->setFormaDePago($row["formaDePago"]);
                $pago->setPrecioGuardian(($pago->getMontoAPagar() * 2));
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
                $pago->setMontoAPagar($row["montoAPagar"]);
                $pago->setPrimerPagoReserva($row["primerPagoReserva"]);
                $pago->setPagoFinal($row["pagoFinal"]);
                $pago->setFormaDePago($row["formaDePago"]);
                $pago->setPrecioGuardian(($pago->getMontoAPagar() * 2));
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

    function getPagosByDniDueno($dniDueno)
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
                $pago->setMontoAPagar($row["montoAPagar"]);
                $pago->setPrimerPagoReserva($row["primerPagoReserva"]);
                $pago->setPagoFinal($row["pagoFinal"]);
                $pago->setFormaDePago($row["formaDePago"]);
                $pago->setPrecioGuardian(($pago->getMontoAPagar() * 2));
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

    function updatePrimerPagoReservaById($id){
        try {
            $query = "UPDATE " . $this->tableName . " SET primerPagoReserva = :primerPagoReserva WHERE id = :id;";

            $parameters["primerPagoReserva"] = true;
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function updatePagoFinalReservaById($id){
        try {
            $query = "UPDATE " . $this->tableName . " SET pagoFinal = :pagoFinal WHERE id = :id;";

            $parameters["pagoFinal"] = true;
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function updateFormaDePagoReservaById($formaPago, $id){
        try {
            $query = "UPDATE " . $this->tableName . " SET formaDePago = :formaDePago WHERE id = :id;";

            $parameters["formaDePago"] = $formaPago;
            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function removePagoById($idPago)
    {

        try {
            $solicitud = null;

            $query = "DELETE FROM " . $this->tableName . " WHERE id = :id";

            $parameters["id"] = $idPago;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
