<?php

namespace DAO\MYSQL;

use Models\Guardian as Guardian;
use Models\Solicitud as Solicitud;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class GuardianDAO
{
    private $connection;
    private $tableName = "guardianes";

    public function Add(Guardian $guardian)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (username, nombre, password, precio, dni, email, telefono, direccion, tipo, FechaInicio, FechaFin, tamanoACuidar)
             VALUES (:username, :nombre, :password, :precio, :dni, :email, :telefono, :direccion, :tipo, :FechaInicio, :FechaFin, :tamanoACuidar);";

            $parameters["username"] = $guardian->getUsername();
            $parameters["nombre"] = $guardian->getNombre();
            $parameters["password"] = $guardian->getPassword();
            $parameters["precio"] = $guardian->getPrecio();
            $parameters["dni"] = $guardian->getDni();
            $parameters["email"] = $guardian->getEmail();
            $parameters["telefono"] = $guardian->getTelefono();
            $parameters["direccion"] = $guardian->getDireccion();
            $parameters["tipo"] = $guardian->getTipo();
            //$parameters["reservas"] = $guardian->getReservas();
            $parameters["FechaInicio"] = $guardian->getDisponibilidadInicio();
            $parameters["FechaFin"] = $guardian->getDisponibilidadFin();
            $parameters["tamanoACuidar"] = $guardian->getTamanoACuidar();
            //$parameters["solicitudes"] = $guardian->getSolicitudes();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $guardianList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $guardian = new Guardian();
                $guardian->setUsername($row["username"]);
                $guardian->setNombre($row["nombre"]);
                $guardian->setPassword($row["password"]);
                $guardian->setPrecio($row["precio"]);
                $guardian->setDni($row["dni"]);
                $guardian->setEmail($row["email"]);
                $guardian->setTelefono($row["telefono"]);
                $guardian->setDireccion($row["direccion"]);
                $guardian->setTipo($row["tipo"]);
                //$guardian->setReservas($row["reservas"]);
                $guardian->setDisponibilidadInicio($row["FechaInicio"]);
                $guardian->setDisponibilidadFin($row["FechaFin"]);
                $guardian->setTamanoACuidar($row["tamanoACuidar"]);
                //$guardian->setReputacion($row["reputacion"]);
                //$guardian->setSolicitudes($row["solicitudes"]);
                array_push($guardianList, $guardian);
            }
            return $guardianList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetByDni($dni)
    {
        try {
            $guardian = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE dni = :dni";

            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $guardian = new Guardian();
                $guardian->setUserName($row["username"]);
                $guardian->setNombre($row["nombre"]);
                $guardian->setPassword($row["password"]);
                $guardian->setPrecio($row["precio"]);
                $guardian->setDni($row["dni"]);
                $guardian->setEmail($row["email"]);
                $guardian->setTelefono($row["telefono"]);
                $guardian->setDireccion($row["direccion"]);
                $guardian->setTipo($row["tipo"]);
                $guardian->setDisponibilidadInicio($row["FechaInicio"]);
                $guardian->setDisponibilidadFin($row["FechaFin"]);
                $guardian->setTamanoACuidar($row["tamanoACuidar"]);
                
            }

            return $guardian;
        } catch (Exception $ex) {
            throw $ex;
        }
    }


    function getByUsername($username)
    {
        try {
            $guardian = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE username = :username";

            $parameters["username"] = $username;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $guardian = new Guardian();
                $guardian->setUserName($row["username"]);
                $guardian->setNombre($row["nombre"]);
                $guardian->setPassword($row["password"]);
                $guardian->setPrecio($row["precio"]);
                $guardian->setDni($row["dni"]);
                $guardian->setEmail($row["email"]);
                $guardian->setTelefono($row["telefono"]);
                $guardian->setDireccion($row["direccion"]);
                $guardian->setTipo($row["tipo"]);
                $guardian->setDisponibilidadInicio($row["FechaInicio"]);
                $guardian->setDisponibilidadFin($row["FechaFin"]);
                $guardian->setTamanoACuidar($row["tamanoACuidar"]);
                
            }

            return $guardian;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateDisponibilidad($dni, $fini, $ffin)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET FechaInicio = :FechaInicio, FechaFin = :FechaFin WHERE dni = :dni;";

            $parameters["FechaInicio"] = $fini;
            $parameters["FechaFin"] = $ffin;
            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            return false;
            //throw $ex;
        }
    }

    public function removeGuardianByDni($dni){

        try
        {
            $solicitud = null;

            $query = "DELETE FROM ".$this->tableName." WHERE dni = :dni";

            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);
            
      
            return true;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

}
