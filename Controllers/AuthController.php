<?php

namespace Controllers;

use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\DuenoDAO as DuenoDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\ReservaDAO;
use DAO\MYSQL\PagoDAO;
use DAO\MYSQL\ResxMascDAO;
use DAO\MYSQL\SolicitudDAO;
use DAO\MYSQL\SolixMascDAO;
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
      $alert = new Alert("warning", "error en base de datos");
      $this->Index($alert);
    }
    if ($bool == false) {
      $alert = new Alert("warning", "Error iniciando sesion");
      $this->Index($alert);
    }
  }

  private function validacionesLogin() //agrandar luego con pagos
  {    ///CAMBIAR TEMA RESERVAS CON VALIDACIONES HECHAS PARA RESEÑA
    try {
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
          if (!$guardian->getDisponibilidadFin() && !$guardian->getDisponibilidadInicio()) {
            $solicitudesABorrar = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());

            if (isset($solicitudesABorrar)) {
              foreach ($solicitudesABorrar as $soli) {  //borrar intermedias
                $soliXmasc->removeSolicitudMascIntByIdSolicitud($soli->getId());
                if ($soli->getEsPago())
                  $pagoDAO->removePagoById($soli->getId());
              }
              $solicitud->removeSolicitudesByDniGuardian($guardian->getDni());
            }
            //advertir que disponibilidad es null
          } else if (!UtilsController::ValidarFecha($guardian->getDisponibilidadFin())) { //ver foranea para reducir
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
            ///advertir que disponibilidad es null
          } else if (!UtilsController::ValidarFecha($guardian->getDisponibilidadInicio())) {

            $solicitudesAChequear = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());

            if (isset($solicitudesAChequear)) {
              foreach ($solicitudesAChequear as $soli) {  //chequear y borrar intermedias y solicitudes
                if (UtilsController::ValidarFecha($soli->getFechaInicio())) {
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
              if (UtilsController::ValidarFecha($res->getFechaFin())) {
                $reservaDAO->updateEstado($res->getId(), "finalizado");
                if ($res->getResHechaOrechazada() == false && $res->getCrearResena() == false)
                  $res->setCrearResena(true);
              } else if (UtilsController::ValidarFecha($res->getFechaInicio())) {
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
              if (!UtilsController::ValidarFecha($soli->getFechaInicio())) {
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
              if (UtilsController::ValidarFecha($res->getFechaFin())) {
                $reservaDAO->updateEstado($res->getId(), "finalizado");
                if ($res->getResHechaOrechazada() == false && $res->getCrearResena() == false)
                  $res->setCrearResena(true);
              } else if (UtilsController::ValidarFecha($res->getFechaInicio())) {
                $reservaDAO->updateEstado($res->getId(), "actual");
              }
            }
          }
        }
      }
    } catch (Exception $ex) {
      $alert = new Alert("warning", "error en base de datos");
    }
    return $bool; //////////
  }

  public static function ValidarUsuario($username, $dni, $email) ///validaciones en el registro
  {
    try {
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
    } catch (Exception $ex) {
      $alert = new Alert("warning", "error en base de datos");
    }
  }

  public function Logout()
  {
    session_destroy();
    $this->Index();
  }
}
