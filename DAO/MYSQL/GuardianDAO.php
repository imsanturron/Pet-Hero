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
            $query = "INSERT INTO " . $this->tableName . " (username, nombre, password, precio, dni, email, telefono, direccion, tipo, FechaInicio, FechaFin, tamanoACuidar, cantResenas, puntajeTotal, puntajePromedio)
             VALUES (:username, :nombre, :password, :precio, :dni, :email, :telefono, :direccion, :tipo, :FechaInicio, :FechaFin, :tamanoACuidar, :cantResenas, :puntajeTotal, :puntajePromedio);";

            $parameters["username"] = $guardian->getUsername();
            $parameters["nombre"] = $guardian->getNombre();
            $parameters["password"] = $guardian->getPassword();
            $parameters["precio"] = $guardian->getPrecio();
            $parameters["dni"] = $guardian->getDni();
            $parameters["email"] = $guardian->getEmail();
            $parameters["telefono"] = $guardian->getTelefono();
            $parameters["direccion"] = $guardian->getDireccion();
            $parameters["tipo"] = $guardian->getTipo();
            $parameters["FechaInicio"] = $guardian->getDisponibilidadInicio();
            $parameters["FechaFin"] = $guardian->getDisponibilidadFin();
            $parameters["tamanoACuidar"] = $guardian->getTamanoACuidar();
            $parameters["cantResenas"] = $guardian->getCantResenas();
            $parameters["puntajeTotal"] = $guardian->getPuntajeTotal();
            $parameters["puntajePromedio"] = $guardian->getPuntajePromedio();
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

            $guardianList = $this->setter($resultSet, true);

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

            $guardian = $this->setter($resultSet);

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

            $guardian = $this->setter($resultSet);

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
            throw $ex;
        }
    }

    public function setDisponibilidadEnNull($dni)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET FechaInicio = :FechaInicio, FechaFin = :FechaFin WHERE dni = :dni;";

            $parameters["FechaInicio"] = null;
            $parameters["FechaFin"] = null;
            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getTelefonos()
    {
        try {
            $telefonoList = array();
            $query = "SELECT telefono FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $guardian = new Guardian();
                $guardian->setTelefono($row["telefono"]);
                array_push($telefonoList, $guardian);
            }
            return $telefonoList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getCantResenasByDni($dni)
    {
        try {
            $guardian = null;

            $query = "SELECT cantResenas FROM " . $this->tableName . " WHERE dni = :dni";

            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $guardian = new Guardian();
                $guardian->setCantResenas($row["cantResenas"]);
            }

            if ($guardian)
                return $guardian->getCantResenas();
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getPuntajeTotalByDni($dni)
    {
        try {
            $guardian = null;

            $query = "SELECT puntajeTotal FROM " . $this->tableName . " WHERE dni = :dni";

            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $guardian = new Guardian();
                $guardian->setPuntajeTotal($row["puntajeTotal"]);
            }

            if ($guardian)
                return $guardian->getPuntajeTotal();
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateCantResenasMas1($dni)
    {
        try {
            $cantRes = $this->getCantResenasByDni($dni);
            $cantRes = $cantRes + 1;

            $query = "UPDATE " . $this->tableName . " SET cantResenas = :cantResenas WHERE dni = :dni;";

            $parameters["cantResenas"] = $cantRes;
            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updatePuntajeTotalMasPuntaje($dni, $puntaje)
    {
        try {
            $punTotal = $this->getPuntajeTotalByDni($dni);
            $punTotal = $punTotal + $puntaje;

            $query = "UPDATE " . $this->tableName . " SET puntajeTotal = :puntajeTotal WHERE dni = :dni;";

            $parameters["puntajeTotal"] = $punTotal;
            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updatePuntajePromedio($dni)
    {
        try {
            $punTotal = $this->getPuntajeTotalByDni($dni);
            $cantRes = $this->getCantResenasByDni($dni);
            $promedio = ($punTotal / $cantRes);

            $query = "UPDATE " . $this->tableName . " SET puntajePromedio = :puntajePromedio WHERE dni = :dni;";

            $parameters["puntajePromedio"] = $promedio;
            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateTamanoACuidar($dni, $tamano)
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET tamanoACuidar = :tamanoACuidar WHERE dni = :dni;";

            $parameters["tamanoACuidar"] = $tamano;
            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function removeGuardianByDni($dni)
    {

        try {
            $solicitud = null;

            $query = "DELETE FROM " . $this->tableName . " WHERE dni = :dni";

            $parameters["dni"] = $dni;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);


            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function updateDatosGuardian($username, $password, $nombre, $email, $direccion, $telefono)
    {
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
            throw $ex;
        }
    }

    function setter($resultSet, $list = false)
    {
        $lista = array();

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
            $guardian->setCantResenas($row["cantResenas"]);
            $guardian->setPuntajeTotal($row["puntajeTotal"]);
            $guardian->setPuntajePromedio($row["puntajePromedio"]);
            if ($list == true)
                array_push($lista, $guardian);
        }
        if ($list == true) {
            if (isset($lista) && !empty($lista))
                return $lista;
            else
                return null;
        } else {
            if (isset($guardian))
                return $guardian;
            else
                return null;
        }
    }

    /*function getGuardianesEntreFechas($desde, $hasta)
    {
        try {
            $guardianList = array();
            
            $query = "SELECT * FROM " . $this->tableName . " WHERE FechaInicio < :FechaInicio AND FechaFin > :FechaFin";

            $parameters["FechaInicio"] = $desde;
            $parameters["FechaFin"] = $hasta;
            
            $this->connection = Connection::GetInstance();
            
            $resultSet = $this->connection->Execute($query, $parameters);

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
                $guardian->setDisponibilidadInicio($row["FechaInicio"]);
                $guardian->setDisponibilidadFin($row["FechaFin"]);
                $guardian->setTamanoACuidar($row["tamanoACuidar"]);
                $guardian->setCantResenas($row["cantResenas"]);
                $guardian->setPuntajeTotal($row["puntajeTotal"]);
                $guardian->setPuntajePromedio($row["puntajePromedio"]);
                array_push($guardianList, $guardian);
            }
            return $guardianList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }*/
}
