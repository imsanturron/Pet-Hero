<?php

namespace Controllers;

use DAO\GuardianDAO as GuardianDao;
use DAO\DuenoDAO as DuenoDAO;
use DAO\UserDAO as UserDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;
use Models\Alert as Alert; ////////////

class AuthController
{
  private $bool;

  public function Index(Alert $alert = null)
  {
    require_once(VIEWS_PATH . "home.php");
  }

  public function Login($username, $password)
  {
    $users = new UserDAO;
    $tipo = $users->getTipoByUsername($username);
    $bool = false;

    if ($tipo) {
      if ($tipo == 'g') {
        $guardianes = new GuardianDAO;
        $guardianx = new Guardian;
        $guardianx = $guardianes->getByUsername($username);
        if ($guardianx && $guardianx->getPassword() == $password) {
          $bool = true;
          $_SESSION["loggedUser"] = $guardianx;
          $_SESSION["tipo"] = "g";
          ///alerta buena
          require_once(VIEWS_PATH . "loginGuardian.php");
        } else {
          $alert = new Alert("warning", "Fecha invalida");
          $this->Index($alert);
        }
      } else {
        $duenos = new DuenoDAO;
        $duenox = new Dueno;
        $duenox = $duenos->getByUsername($username);
        if ($duenox && $duenox->getPassword() == $password) {
          $bool = true;
          $_SESSION["loggedUser"] = $duenox;
          $_SESSION["tipo"] = "d";
          ///alerta buena
          require_once(VIEWS_PATH . "loginDueno.php");
        } else {
          $alert = new Alert("warning", "Fecha invalida");
          $this->Index($alert);
        }
      }
    }
    if ($bool == false) {
      $alert = new Alert("warning", "Fecha invalida");
      $this->Index($alert);
    }
  }

  public static function ValidarUsuario($username, $dni, $email)
  {
    $users = new UserDAO;
    if ($users->getAll() != null) {
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

  public static function ValidarFecha($finic, $ffin = null)
  {
    $fini = explode("-", $finic);
    if ($ffin)
      $ff = explode("-", $ffin);

    if ($fini[0] <= $ff[0] && $fini[1] <= $ff[1] && $fini[2] <= $ff[2]) {
      return true;
    } else
      return false;
  }

  public static function ValidarMismaRaza($animales)
  {
    $bool = false;
  //// ver como hacerlo, loopear array
      /*for ($i = 0; $i < $animales->count(); $i++) {
        $j = $i;
        $compare = $animales[$i]->getRaza();
        for ($j; $j < $animales->count(); $j++) {
          if()
        }
      }*/
      //usort($animales, fn ($a, $b) => $a['raza'] <=> $b['raza']); ///anda?
      //usort($animales, fn($a, $b) => strcmp($a->getRaza(), $b->getRaza()));
      //$compare;
      //for ($i = 0; $i < $animales->count(); $i++) {
      ///VALIDAR QUE SEAN DE DISTINTA RAZA
      //}
  }

  
  
  /*
    $fini = date("Y-m-d", strtotime($finic));
    if ($ffin)
      $ff = date("Y-m-d", strtotime($ffin));

    if ($fini < date("Y-m-d")) {
      if ($ff && $fini < $ff) {
        return true;
      }
      return false;
    }
    return false;

  /*  --- NO BORRAR ---
  if($ffin != null){
    if ((strtotime($finic) < strtotime('now')) && (strtotime($finic) < strtotime($ffin))) 
      return true;
        else
      return false;
  }
    if (strtotime($finic) < strtotime('now'))
      return true;
    else
      return false;
  */


  public function Logout()
  {
    session_destroy();
    $this->Index();
  }
}
