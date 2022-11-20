<?php

namespace DAO\MYSQL;

use Models\Mascota as Mascota;
use Models\ResxMasc as ResxMasc;;

use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class ResxMascDAO
{
    private $connection;
    private $tableName = "reservaxmascota";

    public function add($arrayMascotas, $idReserva)
    {
        try {
            foreach ($arrayMascotas as $masc) {

                $query = "INSERT INTO " . $this->tableName . " (idReserva, idMascota)
             VALUES (:idReserva, :idMascota);";
                $parameters["idReserva"] = $idReserva;
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
            $resXmascList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            foreach ($resultSet as $row) {
                $resXmasc = new ResxMasc();
                $resXmasc->setIdResxMasc($row["idResxMasc"]);
                $resXmasc->setIdReserva($row["idReserva"]);
                $resXmasc->setIdMascota($row["idMascota"]);
                array_push($resXmascList, $resXmasc);
            }
            return $resXmascList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getIdMascotaByIdReserva($idReserva) /////
    {
        try {

            $query = "SELECT idMascota FROM " . $this->tableName . " WHERE idReserva = :idReserva"; //Limit 1?

            $parameters["idReserva"] = $idReserva;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            foreach ($resultSet as $row) {
                $resXmasc = new ResxMasc();
                $resXmasc->setIdMascota($row["idMascota"]);
            }
            return $resXmasc->getIdMascota();
        } catch (Exception $ex) {
            throw $ex;
        }
    }
}
