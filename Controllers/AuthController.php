<?php

namespace Controllers;

//use DAO\JSON\GuardianDAO as GuardianDao;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
//use DAO\JSON\DuenoDAO as DuenoDAO;
use DAO\MYSQL\DuenoDAO as DuenoDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\ReservaDAO;
use DAO\MYSQL\PagoDAO;
use DAO\MYSQL\ResxMascDAO;
use DAO\MYSQL\SolicitudDAO;
use DAO\MYSQL\SolixMascDAO;
//use DAO\JSON\UserDAO as UserDAO;
use DAO\MYSQL\UserDAO as UserDAO;
use Exception;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;
use Models\Reserva as Reserva;
use Models\Alert as Alert; ////////////

class AuthController
{
  private $bool;

  public function Index(Alert $alert = null)
  {
    require_once(VIEWS_PATH . "home.php");
  }

  public function Login($username, $password) //si esta vacio rompe
  {
    try {
      $bool = false;
      $users = new UserDAO;
      $tipo = $users->getTipoByUsername($username);
      //print_r($tipo);

      if ($tipo) {  ///hacer validaciones cuando inician sesion, como de fecha por disponibilidades, etc.
        if ($tipo == 'g') {
          //echo "aaaaaaaaaaaaaaaaaaaaaaaaaaaa";
          $guardianes = new GuardianDAO;
          $guardianx = new Guardian;
          $guardianx = $guardianes->getByUsername($username);
          if ($guardianx && $guardianx->getPassword() == $password) {
            $bool = true;
            $_SESSION["loggedUser"] = $guardianx;
            $_SESSION["tipo"] = "g";
            $this->validacionesLogin();
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
          //var_dump($duenox);
          if ($duenox && $duenox->getPassword() == $password) {
            $bool = true;
            $_SESSION["loggedUser"] = $duenox;
            $_SESSION["tipo"] = "d";
            $this->validacionesLogin();
            ///alerta buena
            require_once(VIEWS_PATH . "loginDueno.php");
          } else {
            $alert = new Alert("warning", "Fecha invalida");
            $this->Index($alert);
          }
        }
      }
    } catch (Exception $ex) {
      $alert = new Alert("warning", "datos incorrectos");
    }
    if ($bool == false) {
      $alert = new Alert("warning", "Error iniciando sesion");
      $this->Index($alert);
    }
  }

  private function validacionesLogin() //agrandar luego con pagos
  {    ///CAMBIAR TEMA RESERVAS CON VALIDACIONES HECHAS PARA RESEÑA
    $bool = false; //actualizar adentro
    if (isset($_SESSION["loggedUser"])) {
      if ($_SESSION["tipo"] == 'g') {
        $guardian = new Guardian();
        $guardian = $_SESSION["loggedUser"];
        $guardianDAO = new GuardianDAO();
        $reservaDAO = new ReservaDAO();
        $pagoDAO = new PagoDAO();
        $solicitud = new SolicitudDAO();
        $soliXmasc = new SolixMascDAO();

        $solicitudes = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());
        if (!AuthController::ValidarFecha($guardian->getDisponibilidadFin())) { //ver foranea para reducir
          $solicitudesABorrar = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());

          if (isset($solicitudesABorrar)) {
            foreach ($solicitudesABorrar as $soli) {  //borrar intermedias
              $soliXmasc->removeSolicitudMascIntByIdSolicitud($soli->getId());
              if ($soli->getEsPago())
                $pagoDAO->removePagoById($soli->getId());
            }
            $solicitud->removeSolicitudesByDniGuardian($guardian->getDni());
          }
          $guardianDAO->setDisponibilidadEnNull($guardian->getDni());
        } else if (!AuthController::ValidarFecha($guardian->getDisponibilidadInicio())) {

          $solicitudesAChequear = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());

          if (isset($solicitudesAChequear)) {
            foreach ($solicitudesAChequear as $soli) {  //chequear y borrar intermedias y solicitudes
              if (AuthController::ValidarFecha($soli->getFechaInicio())) {
                if ($soli->getEsPago())
                  $pagoDAO->removePagoById($soli->getId());

                $soliXmasc->removeSolicitudMascIntByIdSolicitud($soli->getId());
                $solicitud->removeSolicitudById($soli->getId());
              }
            }
          }
          //advertir que la fecha inicio se paso
        }
        $reservas = $reservaDAO->getReservasByDniGuardian($guardian->getDni());
        if (isset($reservas)) {
          foreach ($reservas as $res) {
            if (AuthController::ValidarFecha($res->getFechaFin())) {
              $reservaDAO->updateEstado($res->getId(), "finalizado");
              if ($res->getHechaOrechazada() == false && $res->getCrearResena() == false)
                $res->setCrearResena(true);
            } else if (AuthController::ValidarFecha($res->getFechaInicio())) {
              $reservaDAO->updateEstado($res->getId(), "actual");
            }
          }
        }
      } else {
        //caso dueño
        $dueno = new Dueno();
        $dueno = $_SESSION["loggedUser"];
        $solicitud = new SolicitudDAO();
        $duenoDAO = new DuenoDAO();
        $reservaDAO = new ReservaDAO();
        $pagoDAO = new PagoDAO();
        $solicitud = new SolicitudDAO();
        $soliXmasc = new SolixMascDAO();
        $solicitudes = $solicitud->getSolicitudesByDniDueno($dueno->getDni());

        if (isset($solicitudes)) {
          foreach ($solicitudes as $soli) {
            if (!AuthController::ValidarFecha($soli->getFechaInicio())) {
              $soliXmasc->removeSolicitudMascIntByIdSolicitud($soli->getId());
              if ($soli->getEsPago())
                $pagoDAO->removePagoById($soli->getId());

              $solicitud->removeSolicitudById($soli->getId());
            }
          }
        }

        $reservas = $reservaDAO->getReservasByDniDueno($dueno->getDni());
        if (isset($reservas)) {
          foreach ($reservas as $res) {
            if (AuthController::ValidarFecha($res->getFechaFin())) {
              $reservaDAO->updateEstado($res->getId(), "finalizado");
              if ($res->getHechaOrechazada() == false && $res->getCrearResena() == false)
                $res->setCrearResena(true);
            } else if (AuthController::ValidarFecha($res->getFechaInicio())) {
              $reservaDAO->updateEstado($res->getId(), "actual");
            }
          }
        }
      }
    }
    return $bool; //////////
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

  public static function ValidarFecha($finic, $ffin = null, $fmedio = null, $despDeHoy = false) //agregar $fmedio, entre 2 fechas. poner despues de ffin en parametros, o ultimo, ver despues.
  {
    $fini = date("Y-m-d", strtotime($finic));
    if ($ffin)
      $ff = date("Y-m-d", strtotime($ffin));
    if ($fmedio)
      $fmed = date("Y-m-d", strtotime($fmedio));

    /*echo "acaa";
    var_dump($fini);
    var_dump($ffin);
    var_dump($fmedio);
    var_dump($despDeHoy);*/

    /*if ($ffin && $fmedio == null && $despDeHoy == false)
      echo "<br>a";

    if ($ffin == null && $fmedio = null)
      echo "<br>b";

    if ($ffin && $fmedio = null && $despDeHoy == true)
      echo "<br>c";

    if ($ffin && $fmedio && $despDeHoy == false)
      echo "<br>d";

    if ($ffin && $fmedio && $despDeHoy == true)
      echo "<br>e";*/

    /*if((strtotime($fini) <= strtotime($ff)))
      echo "<br>a";
      
      if((strtotime($fini) >= strtotime($ff)))
      echo "<br>b";
      
      if((strtotime($fini) == strtotime($ff)))
      echo "<br>c";
      
      if((strtotime($fini) != strtotime($ff)))
      echo "<br>d";*/
    //echo "<br> c1: " . (strtotime($fini) <= strtotime($ff)); //da 1 cuando si y no muestra nada cuando no
    //echo "<br> c2: " . (strtotime($fini) >= strtotime($ff));
    //echo "<br> c3: " . (strtotime($fini) == strtotime($ff));
    //echo "<br> c4: " . (strtotime($fini) != strtotime($ff));
    if ($ffin && $fmedio == null && $despDeHoy == false) { ///verificar si fini es antes de ff
      if (strtotime($fini) <= strtotime($ff))
        return true;
      else
        return false;
    } else if ($ffin == null && $fmedio == null) {
      if (strtotime($fini) >= strtotime(date("Y-m-d"))) ///verificar que fini mayor que hoy
        return true;
      else
        return false;
    } else if ($ffin && $fmedio == null && $despDeHoy == true) { //primer if + fini despues de hoy
      if (strtotime($fini) >= strtotime(date("Y-m-d")) && strtotime($fini) <= strtotime($ff))
        return true;
      else
        return false;
    } else if ($ffin && $fmedio && $despDeHoy == false) { //verificar que $fmedio->$fmed esta entre $fini y $ff
      if (
        strtotime($fini) <= strtotime($ff)
        && strtotime($fini) <= strtotime($fmed)
        && strtotime($fmed) <= strtotime($ff)
      )
        return true;
      else
        return false;
    } else if ($ffin && $fmedio && $despDeHoy == true) { //anterior if + fini >= hoy
      if (
        strtotime($fini) >= strtotime(date("Y-m-d"))
        && strtotime($fini) <= strtotime($ff)
        && strtotime($fini) <= strtotime($fmed)
        && strtotime($fmed) <= strtotime($ff)
      )
        return true;
      else
        return false;
    }
  }

  public static function ValidarMismaRaza($animales, $dniGuard, $desde, $hasta)
  {
    if (isset($animales) && !empty($animales)) {
      $comparador = array();
      $guardianes = new GuardianDAO();
      $guardian = $guardianes->getByDni($dniGuard);
      $reserva = new ReservaDAO();
      $reservas = $reserva->getReservasByDniGuardian($dniGuard);
      if (isset($reservas) && !empty($reservas)) {
        $mascotasXreserva = new ResxMascDAO();
        $mascotas = new MascotaDAO();
        foreach ($reservas as $res) {
          if (
            AuthController::ValidarFecha($res->getFechaInicio(), $desde)
            && AuthController::ValidarFecha($res->getFechaFin(), $hasta)
          ) {
            $idMascota = $mascotasXreserva->getIdMascotaByIdReserva($res->getId());
            $mascotaVerRaza = $mascotas->GetById($idMascota);
            array_push($comparador, $mascotaVerRaza->getRaza());
          }
        }
      }

      for ($i = 0; $i < count($animales); $i++) {
        $j = $i;
        for ($j; $j < count($animales); $j++) {
          if ($j != $i) {
            if ($animales[$i]->getRaza() != $animales[$j]->getRaza()) {
              return false;
            }
          }
        }
      }
      if (isset($comparador) && !empty($comparador)) {
        foreach ($comparador as $raza) { ///compara las razas de reservas existentes con esta. Strings.
          if ($animales[0]->getRaza() != $raza)
            return false;
        }
      }
      return true;
    }

    return false;
  }

  public static function VerifGuardianSoliNuestraRepetida($dniGuard)
  {
    $guardianes = new GuardianDAO(); //
    $guardian = $guardianes->getByDni($dniGuard); //
    $solicitud = new SolicitudDAO();
    $solicitudes = $solicitud->getSolicitudesByDniGuardian($dniGuard);
    if (isset($solicitudes) && !empty($solicitudes)) {
      foreach ($solicitudes as $soli) {
        if ($soli->getDniDueno() == $_SESSION["loggedUser"]->getDni())
          return false;
      }
      return true;
    } else
      return true;
  }

  public static function VerifMascotaNoEstaReservadaEnFecha($arrayMascotas, $fini, $ffin)
  {
    $reservaXmascotas = new ResxMascDAO();
    $resXmasc = $reservaXmascotas->GetAll();
    $reserva = new ReservaDAO();

    foreach ($arrayMascotas as $masc) {
      foreach ($resXmasc as $rmi) {
        if ($rmi->getIdMascota() == $masc->getId()) {
          $res =  $reserva->GetById($rmi->getIdReserva());
          if (
            AuthController::ValidarFecha($res->getFechaInicio(), $res->getFechaFin(), $fini) //cambia con fmedio en validar fecha
            || AuthController::ValidarFecha($res->getFechaInicio(), $res->getFechaFin(), $ffin)
          ) {
            return false; //la mascota esta reservada en esa fecha
          }
        }
      }
    }
    return true;
  }

  public function Logout()
  {
    session_destroy();
    $this->Index();
  }
}
