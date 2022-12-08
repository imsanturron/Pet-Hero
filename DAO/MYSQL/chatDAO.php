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
            $query = "INSERT INTO " . $this->tableName . " (dniDueno, dniGuardian, nuevo, senderUlt)
             VALUES (:dniDueno, :dniGuardian, :nuevo, :senderUlt);";

            $parameters["dniDueno"] = $chat->getDniDueno();
            $parameters["dniGuardian"] = $chat->getDniGuardian();
            $parameters["nuevo"] = $chat->getNuevo();
            $parameters["senderUlt"] = $chat->getSenderUlt();

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

            $query = "SELECT c.*, g.nombre as nombreGuardian, d.nombre as nombreDueno 
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
                $chat->setIdC($row["id"]);
            }

            if ($chat)
                return $chat->getIdC();
            else
                return null;
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

    function getSenderById($id) /////
    {
        try {
            $chat = null;

            $query = "SELECT senderUlt FROM " . $this->tableName . " WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $chat = new Chat();
                $chat->setSenderUlt($row["senderUlt"]);
            }

            if ($chat)
                return $chat->getSenderUlt();
            else
                return null;
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

    function updateNuevo($nuevo, $idc) /////
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET nuevo = :nuevo WHERE id = :id;";

            if ($nuevo == true)
                $parameters["nuevo"] = true;
            else
                $parameters["nuevo"] = false;

            $parameters["id"] = $idc;

            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function updateUltSender($sender, $idc) /////
    {
        try {
            $query = "UPDATE " . $this->tableName . " SET senderUlt = :senderUlt WHERE id = :id;";

            $parameters["senderUlt"] = $sender;
            $parameters["id"] = $idc;

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
            $chat = new Chat();
            $chat->setIdC($row["id"]);
            $chat->setDniDueno($row["dniDueno"]);
            $chat->setNombreGuardian($row["nombreGuardian"]);
            $chat->setNombreDueno($row["nombreDueno"]);
            $chat->setDniGuardian($row["dniGuardian"]);
            $chat->setNuevo($row["nuevo"]);
            $chat->setSenderUlt($row["senderUlt"]);

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
