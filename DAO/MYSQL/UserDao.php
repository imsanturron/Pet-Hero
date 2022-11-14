<?php

namespace DAO\MYSQL;

use Models\User as User;
use DAO\MYSQL\Connection as Connection;
use \Exception as Exception;

class UserDAO
{
  private $connection;
  private $tableName = "usuarios";

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
        $usuario->setTipo($row["tipo"]);
      }

      if ($usuario)
        return $usuario->getTipo();
      else
        return null;
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

  public function removeUserByDni($dni)
  {

    try {
      $solicitud = null;

      $query = "DELETE FROM " . $this->tableName . " WHERE dni = :dni";

      $parameters["dni"] = $dni;

      $this->connection = Connection::GetInstance();

      $resultSet = $this->connection->Execute($query, $parameters);


      return true;
    } catch (Exception $ex) {
      throw $ex;
    }
  }

  public function modificarPerfil(User $user){

    try {

            $query = "UPDATE ".$this->tableName." SET username= :username, password= :password,email= :email
             WHERE dni = ". $_SESSION["loggedUser"]->getDni() .";";


             $parameters["username"] = $user->getUsername();
             $parameters["password"] = $user->getPassword();
             $parameters["email"] = $user->getEmail();


        $this->connection = Connection::GetInstance();

        $this->connection->ExecuteNonQuery($query, $parameters);

    } catch (Excepcion $ex){
        throw $ex;
    }
}


  ///////////////////////////////////////////FUNCIONES JSONJJSONJSON/////////////////////////////////////////////////
  /////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
}
