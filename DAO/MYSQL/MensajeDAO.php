<?php

namespace DAO\MYSQL;

use Models\Guardian as Guardian;
use Models\Mensaje as Mensaje;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class MensajeDAO
{
    private $connection;
    private $tableName = "Mensajes";

    public function Add(Mensaje $mensaje)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (idChat, mensaje, fecha, senderMsj)
             VALUES (:idChat, :mensaje, :fecha, :senderMsj);";

            $parameters["idChat"] = $mensaje->getIdChat();
            $parameters["mensaje"] = $mensaje->getMensaje();
            $parameters["fecha"] = $mensaje->getFecha();
            $parameters["senderMsj"] = $mensaje->getSenderMsj();

            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $mensajeList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            $mensajeList = $this->setter($resultSet, true);

            return $mensajeList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $mensaje = null;

            $query = "SELECT * FROM " . $this->tableName . "WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $mensaje = $this->setter($resultSet);

            return $mensaje;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetIdChatByDniDuenoYGuardian($dniDueno, $dniGuardian)
    {
        try {
            $mensaje = null;

            $query = "SELECT idChat FROM " . $this->tableName . " WHERE dniDueno = :dniDueno AND dniGuardian = :dniGuardian";

            $parameters["dniDueno"] = $dniDueno;
            $parameters["dniGuardian"] = $dniGuardian;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $mensaje = new Mensaje();
                $mensaje->setIdChat($row["idChat"]);
            }

            return $mensaje->getIdChat();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getHistorialMensajesByIdChat($idChat) /////
    {
        try {
            $mensajeList = array();

            $query = "SELECT * FROM " . $this->tableName . " WHERE idChat = :idChat";

            $parameters["idChat"] = $idChat;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $mensajeList = $this->setter($resultSet, true);

            return $mensajeList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function setter($resultSet, $list = false)
    {
        $lista = array();

        foreach ($resultSet as $row) {
            $mensaje = new Mensaje();
            $mensaje->setIdM($row["id"]);
            $mensaje->setIdChat($row["idChat"]);
            $mensaje->setMensaje($row["mensaje"]);
            $mensaje->setFecha($row["fecha"]);
            $mensaje->setSenderMsj($row["senderMsj"]);

            if ($list == true)
                array_push($lista, $mensaje);
        }
        if ($list == true) {
            if (isset($lista) && !empty($lista))
                return $lista;
            else
                return null;
        } else {
            if (isset($mensaje))
                return $mensaje;
            else
                return null;
        }
    }
}
