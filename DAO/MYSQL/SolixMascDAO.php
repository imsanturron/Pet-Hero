<?php

namespace DAO\MYSQL;

use Models\Mascota as Mascota;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;
use Models\ResxMasc;
use Models\SolixMasc;

class SolixMascDAO
{
    private $connection;
    private $tableName = "solicitudxmascota";

    public function add($arrayMascotas, $idSolicitud)
    {
        try {
            foreach ($arrayMascotas as $masc) {
                $query = "INSERT INTO " . $this->tableName . " (idSolicitud, idMascota)
             VALUES (:idSolicitud, :idMascota);";
                $parameters["idSolicitud"] = $idSolicitud;
                $parameters["idMascota"] = $masc->getId();
                $this->connection = Connection::GetInstance();
                $this->connection->ExecuteNonQuery($query, $parameters);
            }
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $soliXmascList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $soliXmasc = new SolixMasc();
                $soliXmasc->setIdSolixMasc($row["idSolixMasc"]);
                $soliXmasc->setIdSolicitud($row["idSolicitud"]);
                $soliXmasc->setIdMascota($row["idMascota"]);
                array_push($soliXmascList, $soliXmasc);
            }

            if (isset($soliXmascList) && !empty($soliXmascList))
                return $soliXmascList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getIdMascotaByIdSolicitud($idSolicitud)
    {
        try {

            $query = "SELECT idMascota FROM " . $this->tableName . " WHERE idSolicitud = :idSolicitud"; //Limit 1?

            $parameters["idSolicitud"] = $idSolicitud;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $soliXmasc = new SolixMasc();
                $soliXmasc->setIdMascota($row["idMascota"]);
            }
            return $soliXmasc->getIdMascota();
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getAllIdMascotaByIdSolicitud($idSolicitud)
    {
        try {
            $soliXmascList = array();

            $query = "SELECT idMascota FROM " . $this->tableName . " WHERE idSolicitud = :idSolicitud"; //Limit 1?

            $parameters["idSolicitud"] = $idSolicitud;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                array_push($soliXmascList, $row["idMascota"]);
            }

            if (isset($soliXmascList) && !empty($soliXmascList))
                return $soliXmascList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function removeSolicitudMascIntById($idIntermedia)
    {
        try {
            $solicitud = null;

            $query = "DELETE FROM " . $this->tableName . " WHERE idSolixMasc = :idSolixMasc";

            $parameters["idSolixMasc"] = $idIntermedia;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function removeSolicitudMascIntByIdSolicitud($idSolicitud)
    {
        try {
            $solicitud = null;

            $query = "DELETE FROM " . $this->tableName . " WHERE idSolicitud = :idSolicitud";

            $parameters["idSolicitud"] = $idSolicitud;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
