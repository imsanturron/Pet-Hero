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

    public function Add(Chat $chat)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (dniDueno, dniGuardian, mensaje, fecha, sender)
             VALUES (:dniDueno, :dniGuardian, :mensaje, :fecha, :sender);";

            $parameters["dniDueno"] = $chat->getDniDueno();
            $parameters["dniGuardian"] = $chat->getDniGuardian();
            $parameters["mensaje"] = $chat->getMensaje();
            $parameters["fecha"] = $chat->getFecha();
            $parameters["sender"] = $chat->getSender();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $chatList = array();
            $query = "SELECT c.*, g.nombre as nombreGuardian, d.nombre as nombreDueno,mensaje
              FROM " . $this->tableName . " c join duenos d on c.dniDueno = c.dni join guardianes g on c.dniGuardian = g.dni";
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            $chatList = $this->setter($resultSet, true);

            return $chatList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $chat = null;

            $query = "SELECT c.*, g.nombre as nombreGuardian, d.nombre as nombreDueno, 
             FROM " . $this->tableName . " c join duenos d on c.dniDueno = d.dni join guardianes g on c.dniGuardian = g.dni WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $chat = $this->setter($resultSet);

            return $chat;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetIdByDniDuenoYGuardian($dniDueno, $dniGuardian)
    {
        try {
            $chat = null;

            $query = "SELECT id FROM " . $this->tableName . " WHERE dniDueno = :dniDueno AND dniGuardian = :dniGuardian";

            $parameters["dniDueno"] = $dniDueno;
            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $chat = new Chat();
                $chat->setId($row["id"]);
            }

            return $chat->getId();
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
            $chatList = array();

            $query = "SELECT c.*, g.nombre as nombreGuardian, d.nombre as nombreDueno
            FROM " . $this->tableName . " c join duenos d on c.dniDueno = d.dni join guardianes g on c.dniGuardian = g.dni WHERE dniDueno = :dniDueno";

            $parameters["dniDueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $chatList = $this->setter($resultSet, true);

            return $chatList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getHistorialChatsByDnis($dniDueno, $dniGuardian) /////
    {
        try {
            $chatList = array();

            $query = "SELECT c.*, g.nombre as nombreGuardian, d.nombre as nombreDueno
            FROM " . $this->tableName . " c join duenos d on c.dniDueno = d.dni join guardianes g on c.dniGuardian = g.dni WHERE dniDueno = :dniDueno AND dniGuardian = :dniGuardian";

            $parameters["dniDueno"] = $dniDueno;
            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $chatList = $this->setter($resultSet, true);

            return $chatList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function setter($resultSet, $list = false)
    {
        $lista = array();

        foreach ($resultSet as $row) {
            $chat = new Chat();
            $chat->setId($row["id"]);
            $chat->setDniDueno($row["dniDueno"]);
            $chat->setNombreGuardian($row["nombreGuardian"]);
            $chat->setNombreDueno($row["nombreDueno"]);
            $chat->setDniGuardian($row["dniGuardian"]);
            $chat->setMensaje($row["mensaje"]);
            $chat->setFecha($row["fecha"]);
            $chat->setSender($row["sender"]);

            if ($list == true)
                array_push($lista, $chat);
        }
        if ($list == true) {
            if (isset($lista) && !empty($lista))
                return $lista;
            else
                return null;
        } else {
            if (isset($chat))
                return $chat;
            else
                return null;
        }
    }
}
