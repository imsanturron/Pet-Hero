<?php

namespace DAO\MYSQL;

use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;
use Models\Tarjeta as Tarjeta;

class TarjetaDAO
{
  private $connection;
  private $tableName = "tarjetas";

  public function Add(Tarjeta $tarjeta)
  {
    try {
      $query = "INSERT INTO " . $this->tableName . " (numeroTarjeta, dniPropietario, nombreTarjeta, vencimiento, codigoSeguridad)
             VALUES (:numeroTarjeta, :dniPropietario, :nombreTarjeta, :vencimiento, :codigoSeguridad);";

      $parameters["numeroTarjeta"] = $tarjeta->getNumeroTarjeta();
      $parameters["dniPropietario"] = $tarjeta->getDniPropietario();
      $parameters["nombreTarjeta"] = $tarjeta->getNombreTarjeta();
      $parameters["vencimiento"] = $tarjeta->getVencimiento();
      $parameters["codigoSeguridad"] = $tarjeta->getCodigoSeguridad();
      $this->connection = Connection::GetInstance();
      $this->connection->ExecuteNonQuery($query, $parameters);
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  public function GetAll()
  {
    try {
      $tarjetaList = array();
      $query = "SELECT * FROM " . $this->tableName;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);

      $tarjetaList = $this->setter($resultSet, true);

      return $tarjetaList;
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  function GetByNumeroTarjeta($numeroTarjeta)
  {
    try {
      $tarjeta = null;

      $query = "SELECT * FROM " . $this->tableName . " WHERE numeroTarjeta = :numeroTarjeta";

      $parameters["numeroTarjeta"] = $numeroTarjeta;

      $this->connection = Connection::GetInstance();

      $resultSet = $this->connection->Execute($query, $parameters);

      $tarjeta = $this->setter($resultSet);

      return $tarjeta;
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  function GetTarjetasByDniPropietario($dniPropietario)
  {
    try {
      $tarjetaList = array();

      $query = "SELECT * FROM " . $this->tableName . " WHERE dniPropietario = :dniPropietario";

      $parameters["dniPropietario"] = $dniPropietario;

      $this->connection = Connection::GetInstance();

      $resultSet = $this->connection->Execute($query, $parameters);

      $tarjetaList = $this->setter($resultSet, true);

      return $tarjetaList;
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  public function removeByNumeroTarjeta($numeroTarjeta)
  {

    try {
      $query = "DELETE FROM " . $this->tableName . " WHERE numeroTarjeta = :numeroTarjeta";

      $parameters["numeroTarjeta"] = $numeroTarjeta;

      $this->connection = Connection::GetInstance();

      $resultSet = $this->connection->Execute($query, $parameters);

      return true;
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  public function removeByDniPropietario($dniPropietario)
  {

    try {
      $query = "DELETE FROM " . $this->tableName . " WHERE dniPropietario = :dniPropietario";

      $parameters["dniPropietario"] = $dniPropietario;

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
      $tarjeta = new Tarjeta();
      $tarjeta->setNumeroTarjeta($row["numeroTarjeta"]);
      $tarjeta->setDniPropietario($row["dniPropietario"]);
      $tarjeta->setNombreTarjeta($row["nombreTarjeta"]);
      $tarjeta->setVencimiento($row["vencimiento"]);
      $tarjeta->setCodigoSeguridad($row["codigoSeguridad"]);
      if ($list == true)
        array_push($lista, $tarjeta);
    }
    if ($list == true) {
      if (isset($lista) && !empty($lista))
        return $lista;
      else
        return null;
    } else {
      if (isset($tarjeta))
        return $tarjeta;
      else
        return null;
    }
  }
}
