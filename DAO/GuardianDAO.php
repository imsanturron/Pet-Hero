<?php

namespace DAO;

use Models\Guardian as Guardian;
use Models\Solicitud as Solicitud;
use DAO\Connection as Connection;
use \Exception as Exception;

class GuardianDAO
{
    //private $connection;
    //private $tableName = "guardianes";
    private $usuarioList = array();
    private $filename;

    public function __construct()
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
                $this->SaveData();
                return true;
            }
        }
        return false;
    }

    /**BUsca factura por numero y tipo  en archivo retorna true o false */
    public function search(Guardian $user)
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
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////FUNCIONES BASE DE DATOS/////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    /*public function Add(Guardian $guardian)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (username, nombre, password, precio, dni, email, cuil, direccion, tipo, reservas, FechaInicio, FechaFin, solicitudes)
             VALUES (:username, :nombre, :password, :precio, :dni, :email, :cuil, :direccion, :tipo, :reservas, :FechaInicio, :FechaFin, :solicitudes);";
            
              $parameters["username"] = $guardian->getUsername();
              $parameters["nombre"] = $guardian->getNombre();
              $parameters["password"] = $guardian->getPassword();
              $parameters["precio"] = $guardian->getPrecio();
              $parameters["dni"] = $guardian->getDni();
              $parameters["email"] = $guardian->getEmail();
              $parameters["cuil"] = $guardian->getCuil();
              $parameters["direccion"] = $guardian->getDireccion();
              $parameters["tipo"] = $guardian->getTipo();
              $parameters["reservas"] = $guardian->getReservas();
              $parameters["FechaInicio"] = $guardian->getDisponibilidadInicio();
              $parameters["FechaFin"] = $guardian->getDisponibilidadFin();
              $parameters["solicitudes"] = $guardian->getSolicitudes();
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }*/

    /*public function GetAll()
        {
            try
            {
                $guardianList = array();
                $query = "SELECT * FROM ".$this->tableName;
                $this->connection = Connection::GetInstance();
                $resultSet = $this->connection->Execute($query);
                
                foreach ($resultSet as $row)
                {                
                    $guardian = new Guardian();
                    $guardian->setUsername($valueArray["username"]);
                    $guardian->setNombre($valueArray["nombre"]);
                    $guardian->setPassword($valueArray["password"]);
                    $guardian->setPrecio($valueArray["precio"]);
                    $guardian->setDni($valueArray["dni"]);
                    $guardian->setEmail($valueArray["email"]);
                    $guardian->setCuil($valueArray["cuil"]);
                    $guardian->setDireccion($valueArray["direccion"]);
                    $guardian->setTipo($valueArray["tipo"]);
                    $guardian->setReservas($valueArray["reservas"]);
                    $guardian->setDisponibilidadInicio($valueArray["FechaInicio"]);
                    $guardian->setDisponibilidadFin($valueArray["FechaFin"]);
                    $guardian->setSolicitudes($valueArray["solicitudes"]);
                    array_push($guardianList, $guardian);
                }
                return $guardianList;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }*/

    /*function GetByDni($dni)
        {
            try
            {
                $guardian = null;

                $query = "SELECT * FROM ".$this->tableName." WHERE dni = :dni";

                $parameters["dni"] = $dni;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);
                
                foreach ($resultSet as $row)
                {                
                    $guardian = new Guardian();
                    $guardian->setDni($row["dni"]);
                    $guardian->setNombre($row["nombre"]);
                    ////////
                }

                return $guardian;
            }
            catch(Exception $ex)
            {
                throw $ex;
            }
        }*/
}
