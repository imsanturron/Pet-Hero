<?php

namespace Controllers;

use DAO\GuardianDAO as GuardianDao;
use DAO\DuenoDAO as DuenoDAO;
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

  public function Logout()
  {
    session_destroy();
    require_once(VIEWS_PATH . "home.php");
  }
}
