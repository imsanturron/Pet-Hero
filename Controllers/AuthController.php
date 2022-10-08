<?php

namespace Controllers;

use DAO\GuardianDAO as GuardianDao;
use DAO\DuenoDAO as DuenoDAO;
use DAO\UserDAO as UserDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;

class AuthController
{
  private $bool;

  public function Login($username, $password, $tipo)
  {
    $bool = false;

    if ($tipo == 'g') {
      $guardianes = new GuardianDAO;
      $guardianx = new Guardian;
      $guardianx = $guardianes->getByUsername($username);
      if ($guardianx && $guardianx->getPassword() == $password) {
        $bool = true;
        $_SESSION["loggedUser"] = $guardianx;
        require_once(VIEWS_PATH . "loginGuardian.php");
      } else {
        require_once(VIEWS_PATH . "home.php");
      }
    } else {
      $duenos = new DuenoDAO;
      $duenox = new Dueno;
      $duenox = $duenos->getByUsername($username);
      if ($duenox && $duenox->getPassword() == $password) {
        $bool = true;
        $_SESSION["loggedUser"] = $duenox;
        require_once(VIEWS_PATH . "loginDueno.php");
      } else {
        require_once(VIEWS_PATH . "home.php");
      }
    }

    if ($bool = false)
      require_once(VIEWS_PATH . "home.php");
  }

  public static function ValidarUsuario($username, $dni, $email)
  {
    $users = new UserDAO;
    if($users->getAll() != null){
    $a = $users->getByDni($dni);
    $b = $users->getByUsername($username);
    $c = $users->getByEmail($email);
    if ($a != null || $b != null || $c != null)
      return false;
    else
      return true;
    }
    return true;
  }

  public function Logout()
  {
    session_destroy();
    require_once(VIEWS_PATH . "home.php");
  }
}
