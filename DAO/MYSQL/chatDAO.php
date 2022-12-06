<?php

namespace DAO\MYSQL;

use Models\Guardian as Guardian;
use Models\Chat as Chat;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class ChatDAO
{
    private $connection;
    private $tableName = "Chats";

    public function Add(Chat $Chat)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (dniDueno,dniGuardian,nombreDueno,nombreGuardian,mensaje)
             VALUES (:dniDueno,:dniGuardian,:nombreDueno,:nombreGuardian,:mensaje);";

            $parameters["dniDueno"] = $Chat->getDniDueno();
            $parameters["dniGuardian"] = $Chat->getDniGuardian();
            $parameters["nombreDueno"] = $Chat->getNombreDueno();
            $parameters["nombreGuardian"] = $Chat->getNombreGuardian();
            $parameters["mensaje"] = $Chat->getMensaje();
            
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $ChatList = array();
            $query = "SELECT c.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,mensaje
              FROM " . $this->tableName . " c join duenos d on c.dniDueno = c.dni join guardianes g on c.dniGuardian = g.dni";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            $ChatList = $this->setter($resultSet, true);

            return $ChatList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $Chat = null;

            $query = "SELECT c.*, g.nombre as nombreGuardian, d.nombre as nombreDueno, 
             FROM " . $this->tableName . " c join duenos d on c.dniDueno = d.dni join guardianes g on c.dniGuardian = g.dni WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $Chat = $this->setter($resultSet);

            return $Chat;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetIdByDniDuenoYGuardian($dniDueno, $dniGuardian)
    {
        try {
            $Chat = null;

            $query = "SELECT id FROM " . $this->tableName . " WHERE dniDueno = :dniDueno AND dniGuardian = :dniGuardian";


            $parameters["dniDueno"] = $dniDueno;
            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $Chat = new Chat();
                $Chat->setId($row["id"]);
            }

            return $Chat->getId();
        } catch (Exception $ex) {
            throw $ex;
        }
    }



    function getChatsByDniGuardian($dniGuardian) /////
    {
        try {
            $ChatList = array();

            $query = "SELECT c.*, g.nombre as nombreGuardian, d.nombre as nombreDueno, 
            FROM " . $this->tableName . " c join duenos d on c.dniDueno = d.dni join guardianes g on c.dniGuardian = g.dni WHERE dniGuardian = :dniGuardian";

            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $ChatList = $this->setter($resultSet, true);

            return $ChatList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getChatsByDniDueno($dniDueno) /////
    {
        try {
            $ChatList = array();


            $query = "SELECT c.*, g.nombre as nombreGuardian, d.nombre as nombreDueno
            FROM " . $this->tableName . " c join duenos d on c.dniDueno = d.dni join guardianes g on c.dniGuardian = g.dni WHERE dniDueno = :dniDueno";

            $parameters["dniDueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $ChatList = $this->setter($resultSet, true);

            return $ChatList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }



    function setter($resultSet, $list = false)
    {
        $lista = array();

        foreach ($resultSet as $row) {
            $Chat = new Chat();
            $Chat->setId($row["id"]);
      
            $Chat->setDniDueno($row["dniDueno"]);
            $Chat->setNombreGuardian($row["nombreGuardian"]);
            $Chat->setNombreDueno($row["nombreDueno"]);
            $Chat->setDniGuardian($row["dniGuardian"]);
            $Chat->setMensaje($row["mensaje"]);
            
            if ($list == true)
                array_push($lista, $Chat);
        }
        if ($list == true) {
            if (isset($lista) && !empty($lista))
                return $lista;
            else
                return null;
        } else {
            if (isset($Chat))
                return $Chat;
            else
                return null;
        }
    }
}
