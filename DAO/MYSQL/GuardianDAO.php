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
    //private $usuarioList = array();
    //private $filename;

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
                ////////
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
                ////////
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

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////FUNCIONES JSONJJSONJSON/////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*public function __construct()
    {
        $this->filename = dirname(__DIR__) . "\Data\Guardian" . ".json";
    }

    public function add(Guardian $user)
    {
        $this->retrieveData();
        array_push($this->usuarioList, $user);
        $this->saveData();
    }


    public function remove(Guardian $user)
    {
        $this->retrieveData();

        if (($clave = array_search($user, $this->usuarioList)) !== false) {

            unset($this->usuarioList[$clave]);
        }

        $this->SaveData();
    }

    public function getByUsername($user)
    {
        $this->retrieveData();
        foreach ($this->usuarioList as $item) {
            if ($item->getUsername() == $user)
                return $item;
        }
        return null;
    }

    public function getByDni($dni)
    {
        $this->retrieveData();
        foreach ($this->usuarioList as $item) {
            if ($item->getDni() == $dni)
                return $item;
        }
        return null;
    }

    public function addSolicitudDao(Solicitud $solicitud, $dni)
    {
        $this->retrieveData();
        foreach ($this->usuarioList as $item) {
            if ($item->getDni() == $dni) {
                $item->addSolicitud($solicitud);
                print_r($item->getSolicitudes());
                $this->SaveData();
                return true;
            }
        }
        return false;
    }

    public function updateDisponibilidad($dni, $fini, $ffin)
    {
        $this->retrieveData();
        foreach ($this->usuarioList as $item) {
            if ($item->getDni() == $dni) {
                $item->setDisponibilidadInicio($fini);
                $item->setDisponibilidadFin($ffin);
                $this->saveData();
                return true;
            }
        }
        return false;
    }

    /**BUsca factura por numero y tipo  en archivo retorna true o false */
    /*public function search(Guardian $user)
    {
        $this->retrieveData();
        $encontrado = false;

        foreach ($this->usuarioList as $element) {

            if ($user->getUsername() == $element->getUsername()) {

                $encontrado = true;
            }
        }
        return $encontrado;
    }

    public function getAll()
    {
        $this->retrieveData();
        return $this->usuarioList;
    }

    public function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->usuarioList as $guardian) {

            $valueArray["username"] = $guardian->getUsername();
            $valueArray["password"] = $guardian->getPassword();
            $valueArray["dni"] = $guardian->getDni();
            $valueArray["cuil"] = $guardian->getCuil();
            $valueArray["precio"] = $guardian->getPrecio();
            $valueArray["nombre"] = $guardian->getNombre();
            $valueArray["email"] = $guardian->getEmail();
            $valueArray["tipo"] = $guardian->getTipo();
            $valueArray["reservas"] = $guardian->getReservas();
            $valueArray["direccion"] = $guardian->getDireccion();
            $valueArray["FechaInicio"] = $guardian->getDisponibilidadInicio();
            $valueArray["FechaFin"] = $guardian->getDisponibilidadFin();
            $valueArray["solicitudes"] = $guardian->getSolicitudes();
            $valueArray["tamanoMasc"] = $guardian->getTamanoACuidar();
            array_push($arrayToEncode, $valueArray);
        }
        $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->filename, $jsonContent);
    }

    private function retrieveData()
    {
        $this->usuarioList = array();

        if (file_exists($this->filename)) {

            $jsonContent = file_get_contents($this->filename);
            $arrayToEncode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach ($arrayToEncode as $valueArray) {

                $usuario = new Guardian();
                $usuario->setUsername($valueArray["username"]);
                $usuario->setNombre($valueArray["nombre"]);
                $usuario->setPassword($valueArray["password"]);
                $usuario->setPrecio($valueArray["precio"]);
                $usuario->setDni($valueArray["dni"]);
                $usuario->setEmail($valueArray["email"]);
                $usuario->setCuil($valueArray["cuil"]);
                $usuario->setDireccion($valueArray["direccion"]);
                $usuario->setTipo($valueArray["tipo"]);
                $usuario->setReservas($valueArray["reservas"]);
                $usuario->setDisponibilidadInicio($valueArray["FechaInicio"]);
                $usuario->setDisponibilidadFin($valueArray["FechaFin"]);
                $usuario->setSolicitudes($valueArray["solicitudes"]);
                $usuario->setTamanoACuidar($valueArray["tamanoMasc"]);
                array_push($this->usuarioList, $usuario);
            }
        }
    }

    public function getUsuarioList()
    {
        return $this->usuarioList;
    }*/
}
