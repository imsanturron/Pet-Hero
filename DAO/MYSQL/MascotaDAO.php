<?php

namespace DAO\MYSQL;

use Models\Mascota as Mascota;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class MascotaDAO
{
    private $connection;
    private $tableName = "mascotas";

    public function Add(Mascota $mascota)
    {
        try {
            $query = "INSERT INTO " . $this->tableName . " (id, nombre, especie, raza, dueno, tamano, observaciones, fotoMascota, video, planVacunacion)
             VALUES (:id, :nombre, :especie, :raza, :dueno, :tamano, :observaciones, :fotoMascota, :video, :planVacunacion);";

            $parameters["id"] = $mascota->getId();
            $parameters["nombre"] = $mascota->getNombre();
            $parameters["especie"] = $mascota->getEspecie();
            $parameters["raza"] = $mascota->getRaza();
            $parameters["dueno"] = $mascota->getDniDueno();
            $parameters["tamano"] = $mascota->getTamano();
            $parameters["observaciones"] = $mascota->getObservaciones();
            $parameters["fotoMascota"] = $mascota->getFotoMascota();
            $parameters["video"] = $mascota->getVideo();
            $parameters["planVacunacion"] = $mascota->getPlanVacunacion();
            ///
            $this->connection = Connection::GetInstance();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function GetAll()
    {
        try {
            $mascotaList = array();
            $query = "SELECT * FROM " . $this->tableName;
            $this->connection = Connection::GetInstance();
            $resultSet = $this->connection->Execute($query);

            $mascotaList = $this->setter($resultSet, true);

            return $mascotaList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getArrayByIds($ids)
    {
        try {
            $mascotaList = array();

            foreach ($ids as $id) { //no usar setter
                $query = "SELECT * FROM " . $this->tableName . " WHERE id = :id";

                $parameters["id"] = $id;

                $this->connection = Connection::GetInstance();

                $resultSet = $this->connection->Execute($query, $parameters);

                foreach ($resultSet as $row) {
                    $mascota = new Mascota();
                    $mascota->setId($row["id"]);
                    $mascota->setNombre($row["nombre"]);
                    $mascota->setRaza($row["raza"]);
                    $mascota->setEspecie($row["especie"]);
                    $mascota->setDniDueno($row["dueno"]);
                    $mascota->setTamano($row["tamano"]);
                    $mascota->setObservaciones($row["observaciones"]);
                    $mascota->setFotoMascota($row["fotoMascota"]);
                    $mascota->setVideo($row["video"]);
                    $mascota->setPlanVacunacion($row["planVacunacion"]);
                    array_push($mascotaList, $mascota);
                }
            }

            return $mascotaList;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function getMascotasByDniDueno($dniDueno)
    {
        try {
            $mascotaList = array();


            $query = "SELECT * FROM " . $this->tableName . " WHERE dueno = :dueno";

            $parameters["dueno"] = $dniDueno;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $mascotaList = $this->setter($resultSet, true);

            if (isset($mascotaList))
                return $mascotaList;
            else
                return null;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function GetById($id)
    {
        try {
            $query = "SELECT * FROM " . $this->tableName . " WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);

            $mascota = $this->setter($resultSet);

            return $mascota;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    public function removeMascotaById($id)
    {

        try {
            $solicitud = null;

            $query = "DELETE FROM " . $this->tableName . " WHERE id = :id";

            $parameters["id"] = $id;

            $this->connection = Connection::GetInstance();

            $resultSet = $this->connection->Execute($query, $parameters);


            return true;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    function setter($resultSet, $list = false)
    {
        $lista = array();

        foreach ($resultSet as $row) {
            $mascota = new Mascota();
            $mascota->setId($row["id"]);
            $mascota->setNombre($row["nombre"]);
            $mascota->setRaza($row["raza"]);
            $mascota->setEspecie($row["especie"]);
            $mascota->setDniDueno($row["dueno"]);
            $mascota->setTamano($row["tamano"]);
            $mascota->setObservaciones($row["observaciones"]);
            $mascota->setFotoMascota($row["fotoMascota"]);
            $mascota->setVideo($row["video"]);
            $mascota->setPlanVacunacion($row["planVacunacion"]);
            if ($list == true)
                array_push($lista, $mascota);
        }
        if ($list == true)
            return $lista;
        else
            return $mascota;
    }
}
