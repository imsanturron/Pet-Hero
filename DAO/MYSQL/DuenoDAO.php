<?php

namespace DAO\MYSQL;

use Models\Dueno as Dueno;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class DuenoDAO
{
    private $connection;
    private $tableName = "duenos";

    public function Add(Dueno $dueno)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (nombre, username, password, dni, email, direccion, telefono, tipo)
             VALUES (:nombre, :username, :password, :dni, :email, :direccion, :telefono, :tipo);";

            $parameters["nombre"] = $dueno->getNombre();
            $parameters["username"] = $dueno->getUsername();
            $parameters["password"] = $dueno->getPassword();
            $parameters["dni"] = $dueno->getDni();
            $parameters["email"] = $dueno->getEmail();
            $parameters["direccion"] = $dueno->getDireccion();
            $parameters["telefono"] = $dueno->getTelefono();
            $parameters["tipo"] = $dueno->getTipo();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $duenoList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $dueno = new Dueno();
                $dueno->setNombre($row["nombre"]);
                $dueno->setUsername($row["username"]);
                $dueno->setPassword($row["password"]);
                $dueno->setDni($row["dni"]);
                $dueno->setEmail($row["email"]);
                $dueno->setDireccion($row["direccion"]);
                $dueno->setTelefono($row["telefono"]);
                $dueno->setTipo($row["tipo"]);
                array_push($duenoList, $dueno);
            }
            return $duenoList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetByDni($dni)
    {
        try {
            $dueno = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE dni = :dni";

            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $dueno = new Dueno();
                $dueno->setNombre($row["nombre"]);
                $dueno->setUserName($row["username"]);
                $dueno->setPassword($row["password"]);
                $dueno->setDni($row["dni"]);
                $dueno->setEmail($row["email"]);
                $dueno->setDireccion($row["direccion"]);
                $dueno->setTelefono($row["telefono"]);
                $dueno->setTipo($row["tipo"]);
            }

            return $dueno;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getByUsername($username)
    {
        try {
            $dueno = null;

            $query = "SELECT * FROM " . $this->tableName . " WHERE username = :username";

            $parameters["username"] = $username;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $dueno = new Dueno();
                $dueno->setNombre($row["nombre"]);
                $dueno->setUserName($row["username"]);
                $dueno->setPassword($row["password"]);
                $dueno->setDni($row["dni"]);
                $dueno->setEmail($row["email"]);
                $dueno->setDireccion($row["direccion"]);
                $dueno->setTelefono($row["telefono"]);
                $dueno->setTipo($row["tipo"]);
            }

            return $dueno;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function removeDuenoByDni($dni){

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
    function getTelefonos() /////
    {
        try {
            $telefonoList = array();
            $query = "SELECT telefono FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $dueno = new Dueno();
                $dueno->setTelefono($row["telefono"]);
                array_push($telefonoList, $dueno);
            }
            return $telefonoList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateDatosDueno($username, $password, $nombre, $email, $direccion, $telefono){
        try {
            $query = "UPDATE " . $this->tableName . " SET username  = :username, password = :password,
             nombre = :nombre, email = :email, direccion = :direccion, telefono = :telefono WHERE dni = :dni;";

            $parameters["username"] = $username;
            $parameters["password"] = $password;
            $parameters["nombre"] = $nombre;
            $parameters["email"] = $email;
            $parameters["direccion"] = $direccion;
            $parameters["telefono"] = $telefono;
            $parameters["dni"] = $_SESSION["loggedUser"]->getDni();

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            return false;
            //throw $ex;
        }
    }

    /*protected function parseToObject($value) { //REVISAR BASTANTE
			$value = is_array($value) ? $value : [];
			$resp = array_map(function($p){
				return new User($p['email'],$p['password_user'],$p['administrador'],$p['id_user']);
            }, $value);
            
            if(empty($resp)){
                return $resp;
            }
            else {
                return count($resp) > 1 ? $resp : $resp['0'];
            }
		}*/
}
