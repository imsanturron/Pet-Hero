<?php

namespace DAO\MYSQL;

use Models\User as User;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class UserDAO
{
  private $connection;
  private $tableName = "usuarios";
  //private $usuarioList = array();
  //private $filename;

  public function Add(User $usuario)
  {
    try {
      $query = "INSERT INTO " . $this->tableName . " (username, password, dni, email,tipo)
             VALUES (:username, :password,:dni, :email, :tipo);";

      $parameters["username"] = $usuario->getUsername();
      $parameters["password"] = $usuario->getPassword();
      $parameters["dni"] = $usuario->getDni();
      $parameters["email"] = $usuario->getEmail();
      $parameters["tipo"] = $usuario->getTipo();
      $this->connection = Connection::GetInstance();
      $this->connection->ExecuteNonQuery($query, $parameters);
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  public function GetAll()
  {
    try {
      $usuarioList = array();
      $query = "SELECT * FROM " . $this->tableName;
      $this->connection = Connection::GetInstance();
      $resultSet = $this->connection->Execute($query);

      foreach ($resultSet as $row) {
        $usuario = new User();
        $usuario->setUsername($row["username"]);
        $usuario->setPassword($row["password"]);
        $usuario->setDni($row["dni"]);
        $usuario->setEmail($row["email"]);
        $usuario->setTipo($row["tipo"]);
        array_push($usuarioList, $usuario);
      }
      return $usuarioList;
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  function GetByDni($dni)
  {
    try {
      $usuario = null;

      $query = "SELECT * FROM " . $this->tableName . " WHERE dni = :dni";

      $parameters["dni"] = $dni;

      $this->connection = Connection::GetInstance();

      $resultSet = $this->connection->Execute($query, $parameters);

      foreach ($resultSet as $row) {
        $usuario = new User();
        $usuario->setDni($row["dni"]);
        $usuario->setNombre($row["nombre"]);
        ////////
      }

      return $usuario;
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  function getTipoByUsername($username) /////
  {
    try {
      $usuario = null;

      $query = "SELECT tipo FROM " . $this->tableName . " WHERE username = :username";

      $parameters["username"] = $username;

      $this->connection = Connection::GetInstance();

      $resultSet = $this->connection->Execute($query, $parameters);

      foreach ($resultSet as $row) {
                $usuario = new User();
                //$usuario->setUserName($row["username"]);
                //$usuario->setPassword($row["password"]);
                //$usuario->setDni($row["dni"]);
                //$usuario->setEmail($row["email"]);
                $usuario->setTipo($row["tipo"]);
                ////////
            }

      //return $resultSet;
      return $usuario->getTipo();
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  function getByUsername($username) /////
  {
    try {
      $usuario = null;

      $query = "SELECT tipo FROM " . $this->tableName . " WHERE username = :username";

      $parameters["username"] = $username;

      $this->connection = Connection::GetInstance();

      $resultSet = $this->connection->Execute($query, $parameters);

      foreach ($resultSet as $row) {
        $usuario = new User();
        $usuario->setUserName($row["username"]);
        $usuario->setPassword($row["password"]);
        $usuario->setDni($row["dni"]);
        $usuario->setEmail($row["email"]);
        $usuario->setTipo($row["tipo"]);
        ////////
      }

      return $usuario;
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  function getByEmail($email) /////
  {
    try {
      $usuario = null;

      $query = "SELECT * FROM " . $this->tableName . " WHERE email = :email";

      $parameters["email"] = $email;

      $this->connection = Connection::GetInstance();

      $resultSet = $this->connection->Execute($query, $parameters);

      foreach ($resultSet as $row) {
        $usuario = new User();
        $usuario->setUserName($row["username"]);
        $usuario->setPassword($row["password"]);
        $usuario->setDni($row["dni"]);
        $usuario->setEmail($row["email"]);
        $usuario->setTipo($row["tipo"]);
        ////////
      }

      return $usuario;
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  /////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////////////FUNCIONES JSONJJSONJSON/////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////


  /*public function __construct()
  {
    $this->filename = dirname(__DIR__) . "\Data\Users" . ".json";
  }

  public function add(User $user)
  {
    $this->retrieveData();
    array_push($this->usuarioList, $user);
    $this->saveData();
  }

  public function remove(User $user)
  {
    $this->retrieveData();

    if (($clave = array_search($user, $this->usuarioList)) !== false) {

      unset($this->usuarioList[$clave]);
    }

    $this->saveData();
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

  public function getTipoByUsername($user)
  {
    $this->retrieveData();
    foreach ($this->usuarioList as $item) {
      if ($item->getUsername() == $user)
        return $item->getTipo(); ///////////
    }
    return null;
  }

  public function getByDni($dni)
  {
    $this->retrieveData();
    foreach ($this->usuarioList as $item) {
      if ($item->getDni() == $dni)
        return $dni;
    }
    return null;
  }

  /*public function getByPais($dni) 
    {
      $this->retrieveData();
      foreach($this->usuarioList as $item) 
      {
        if($item->getPais() == $dni)
          return $dni;
      }
      return null;
    }*/

  /*public function getByEmail($email)
  {
    $this->retrieveData();
    foreach ($this->usuarioList as $item) {
      if ($item->getEmail() == $email)
        return $email;
    }
    return null;
  }

  public function search(User $user)
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

  public function getAll()
  {
    $this->retrieveData();
    return $this->usuarioList;
  }

  public function saveData()
  {
    $arrayToEncode = array();

    foreach ($this->usuarioList as $user) {

      $valueArray["username"] = $user->getUsername();
      $valueArray["password"] = $user->getPassword();
      $valueArray["dni"] = $user->getDni();
      $valueArray["email"] = $user->getEmail();
      $valueArray["tipo"] = $user->getTipo();
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

        $usuario = new User;
        $usuario->setUsername($valueArray["username"]);
        $usuario->setPassword($valueArray["password"]);
        $usuario->setDni($valueArray["dni"]);
        $usuario->setEmail($valueArray["email"]);
        $usuario->setTipo($valueArray["tipo"]);
        array_push($this->usuarioList, $usuario);
      }
    }
  }

  public function getUsuarioList()
  {
    return $this->usuarioList;
  }*/
}
