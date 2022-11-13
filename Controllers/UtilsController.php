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

class UtilsController
{
  private $bool;

  public function Index(Alert $alert = null)
  {
    require_once(VIEWS_PATH . "home.php");
  }

  /* Valida fechas con muchas posibles variantes explicadas mas abajo. */
  public static function ValidarFecha($finic, $ffin = null, $fmedio = null, $despDeHoy = false) //agregar $fmedio, entre 2 fechas. poner despues de ffin en parametros, o ultimo, ver despues.
  {
    if (isset($_SESSION["loggedUser"])) {
      $fini = date("Y-m-d", strtotime($finic));
      if ($ffin)
        $ff = date("Y-m-d", strtotime($ffin));
      if ($fmedio)
        $fmed = date("Y-m-d", strtotime($fmedio));


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
    } else {
      $alert = new Alert("warning", "Debe iniciar sesion");
      UtilsController::Index($alert);
    }
  }

  /* Valida que las mascotas de una solicitud sean todas de la misma raza, y
  tambien se fija que en caso de el guardian ya tener reservas dentro del rango
  de fechas de la solicitud, que esas mascotas ya reservadas sean tambien de la misma
  raza que las de la nueva solicitud enviada */
  public static function ValidarMismaRaza($animales, $dniGuard, $desde, $hasta)
  {
    if (isset($_SESSION["loggedUser"])) {
      if (isset($animales) && !empty($animales)) {
        try {
          $comparador = array(); //compara raza
          //$comparador2 = array(); //compara tamaño x si guardian lo cambio y distinto tamaño tiene misma raza
          $guardianes = new GuardianDAO();
          $guardian = $guardianes->getByDni($dniGuard);
          $reserva = new ReservaDAO();
          $reservas = $reserva->getReservasByDniGuardian($dniGuard);
          if (isset($reservas) && !empty($reservas)) {
            $mascotasXreserva = new ResxMascDAO();
            $mascotas = new MascotaDAO();
            foreach ($reservas as $res) {
              if (
                UtilsController::ValidarFecha($res->getFechaInicio(), $desde)
                && UtilsController::ValidarFecha($res->getFechaFin(), $hasta)
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
        } catch (Exception $ex) {
          $alert = new Alert("warning", "error en base de datos");
          UtilsController::Index($alert);
        }
      }
      return false;
    } else {
      $alert = new Alert("warning", "Debe iniciar sesion");
      UtilsController::Index($alert);
    }
  }

  /* Verifica que no le hayamos enviado a un guardian mas de una solicitud
    en un rango de fechas !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!111 */
  public static function VerifGuardianSoliNuestraRepetida($dniGuard)
  {
    if (isset($_SESSION["loggedUser"])) {
      try {
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
      } catch (Exception $ex) {
        $alert = new Alert("warning", "error en base de datos");
        UtilsController::Index($alert);
      }
    } else {
      $alert = new Alert("warning", "Debe iniciar sesion");
      UtilsController::Index($alert);
    }
  }

  /* Valida que las mascotas que enviamos en una solicitud no esten ya reservadas
    en el rango de fechas que la solicitud tiene. Ya estarian reservadas para esas fechas. */
  public static function VerifMascotaNoEstaReservadaEnFecha($arrayMascotas, $fini, $ffin)
  {
    if (isset($_SESSION["loggedUser"])) {
      try {
        $reservaXmascotas = new ResxMascDAO();
        $resXmasc = $reservaXmascotas->GetAll();
        $reserva = new ReservaDAO();

        foreach ($arrayMascotas as $masc) {
          foreach ($resXmasc as $rmi) {
            if ($rmi->getIdMascota() == $masc->getId()) {
              $res =  $reserva->GetById($rmi->getIdReserva());
              if (
                UtilsController::ValidarFecha($res->getFechaInicio(), $res->getFechaFin(), $fini) //cambia con fmedio en validar fecha
                || UtilsController::ValidarFecha($res->getFechaInicio(), $res->getFechaFin(), $ffin)
              ) {
                return false; //la mascota esta reservada en esa fecha
              }
            }
          }
        }
        return true;
      } catch (Exception $ex) {
        $alert = new Alert("warning", "error en base de datos");
        UtilsController::Index($alert);
      }
    } else {
      $alert = new Alert("warning", "Debe iniciar sesion");
      UtilsController::Index($alert);
    }
  }
}
