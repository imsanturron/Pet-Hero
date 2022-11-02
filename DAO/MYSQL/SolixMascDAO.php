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
    //private $usuarioList = array();
    //private $filename;


    public function add($arrayMascotas, $idSolicitud)
    {
        //$ids = array();
        // array_push($ids, $masc->getId());

        try {
            foreach ($arrayMascotas as $masc) {
                $query = "INSERT INTO " . $this->tableName . " (idSolicitud, idMascota)
             VALUES (:idSolicitud, :idMascota);";
                ///id fk?
                //$parameters["idSolicitud"] = $soliXmasc->getIdSolixMasc();
                $parameters["idSolicitud"] = $idSolicitud;
                $parameters["idMascota"] = $masc->getId();
                ///
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
            return $soliXmascList;
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

    /*function setIdSolicitudEnMascota($mascotas,$idSolicitud) /////
        {
          try {
               
            foreach($mascotas as $mascota){
                $query = "UPDATE " . $this->tableName . " SET idSolicitud = :idSolicitud WHERE id = :id;";
      
                $parameters["idSoliRes"] = $idSolicitud;
                $parameters["id"] = $mascota->getId();
          

            $this->connection = Connection::GetInstance();
      
            $resultSet = $this->connection->Execute($query, $parameters);
      
            foreach ($resultSet as $row) {
                $mascota = new Mascota();
                $mascota->setId($row["id"]);
                $mascota->setNombre($row["nombre"]);
                $mascota->setRaza($row["raza"]);
                $mascota->setEspecie($row["especie"]);
                $mascota->setDniDueno($row["dueno"]);
                $mascota->setIdSoliRes($row["idSoliRes"]);
                $mascota->setTamano($row["tamano"]);
                $mascota->setObservaciones($row["observaciones"]);
             
              ////////

            }
        }
           
      
          } catch (Exception $ex) {
            throw $ex;
          }
        }*/
}
