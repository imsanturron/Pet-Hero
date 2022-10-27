<?php

namespace DAO\MYSQL;

use Models\Dueno as Dueno;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class DuenoDAO
{
    private $connection;
    private $tableName = "duenos";
    //private $usuarioList = array();
    //private $filename;

    public function Add(Dueno $dueno)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (nombre, username, password, dni, email, direccion, telefono, mascotas, tipo, solicitudes, reservas)
             VALUES (:nombre, :username, :password, :dni, :email, :direccion, :telefono, :mascotas, :tipo, :solicitudes, :reservas);";

            $parameters["nombre"] = $dueno->getNombre();
            $parameters["username"] = $dueno->getUsername();
            $parameters["password"] = $dueno->getPassword();
            $parameters["dni"] = $dueno->getDni();
            $parameters["email"] = $dueno->getEmail();
            $parameters["direccion"] = $dueno->getDireccion();
            $parameters["telefono"] = $dueno->getTelefono();
            $parameters["mascotas"] = $dueno->getMascotas();
            $parameters["tipo"] = $dueno->getTipo();
            $parameters["solicitudes"] = $dueno->getSolicitudes();
            $parameters["reservas"] = $dueno->getReservas();
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
                $dueno->setMascotas($row["mascotas"]);
                $dueno->setTipo($row["tipo"]);
                $dueno->setSolicitudes($row["solicitudes"]);
                $dueno->setReservas($row["reservas"]);
                array_push($duenoList, $dueno);
            }
            return $duenoList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////////////////FUNCIONES JSONJSONJSON/////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

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

    /*public function __construct()
    {
        $this->filename = dirname(__DIR__) . "\Data\Dueno" . ".json";
    }*/

    /*public function add(Dueno $user)
    {
        $this->retrieveData();
        array_push($this->usuarioList, $user);
        $this->SaveData();
    }

    public function remove(Dueno $user)
    {

        $this->retrieveData();

        if (($clave = array_search($user, $this->usuarioList)) !== false) {

            unset($this->usuarioList[$clave]);
        }


        $this->SaveData();
    }
    /**Busca factura por numero y tipo  en archivo retorna true o false */
    /*public function search(Dueno $user)
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


    public function getByUsername($user)
    {
        $this->retrieveData();
        foreach ($this->usuarioList as $item) {
            if ($item->getUsername() == $user)
                return $item;
        }
        return null;
    }

    public function getAll()
    {
        $this->retrieveData();
        return $this->usuarioList;
    }

    public function saveData()
    {
        $arrayToEncode = array();

        foreach ($this->usuarioList as $dueno) {

            $valueArray["nombre"] = $dueno->getNombre();
            $valueArray["username"] = $dueno->getUsername();
            $valueArray["password"] = $dueno->getPassword();
            $valueArray["dni"] = $dueno->getDni();
            $valueArray["email"] = $dueno->getEmail();
            $valueArray["direccion"] = $dueno->getDireccion();
            $valueArray["telefono"] = $dueno->getTelefono();
            $valueArray["mascotas"] = $dueno->getMascotas();
            $valueArray["tipo"] = $dueno->getTipo();
            $valueArray["solicitudes"] = $dueno->getSolicitudes();
            $valueArray["reservas"] = $dueno->getReservas();
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

                $usuario = new Dueno;
                $usuario->setNombre($valueArray["nombre"]);
                $usuario->setUsername($valueArray["username"]);
                $usuario->setPassword($valueArray["password"]);
                $usuario->setDni($valueArray["dni"]);
                $usuario->setEmail($valueArray["email"]);
                $usuario->setDireccion($valueArray["direccion"]);
                $usuario->setTelefono($valueArray["telefono"]);
                $usuario->setMascotas($valueArray["mascotas"]);
                $usuario->setTipo($valueArray["tipo"]);
                $usuario->setSolicitudes($valueArray["solicitudes"]);
                $usuario->setReservas($valueArray["reservas"]);
                array_push($this->usuarioList, $usuario);
            }
        }
    }




    public function getUsuarioList()
    {
        return $this->usuarioList;
    }*/
}