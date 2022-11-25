<?php

namespace Controllers;

use DAO\MYSQL\TarjetaDAO as TarjetaDAO;
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
use Models\Alert as Alert;

class UtilsController
{
  private $bool;

  public function Index(Alert $alert = null)
  {
    require_once(VIEWS_PATH . "home.php");
  }

  public function LoginDueno(Alert $alert = null)
  {
    if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == 'd')
      require_once(VIEWS_PATH . "loginDueno.php");
  }

  public function LoginGuardian(Alert $alert = null)
  {
    if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == 'g')
      require_once(VIEWS_PATH . "loginGuardian.php");
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
          $guardianes = new GuardianDAO();
          $guardian = $guardianes->getByDni($dniGuard);
          $reserva = new ReservaDAO();
          $reservas = $reserva->getReservasByDniGuardian($dniGuard);
          if (isset($reservas) && !empty($reservas)) {
            $mascotasXreserva = new ResxMascDAO();
            $mascotas = new MascotaDAO();
            foreach ($reservas as $res) {
              if (
                UtilsController::ValidarFecha($res->getFechaInicio(), $res->getFechaFin(), $desde)
                || UtilsController::ValidarFecha($res->getFechaInicio(), $res->getFechaFin(), $hasta)
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
    en un rango de fechas */
  public static function VerifGuardianSoliNuestraRepetida($dniGuard, $fini, $ffin)
  {
    if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == 'd') {
      try {
        $guardianes = new GuardianDAO(); //
        $solicitud = new SolicitudDAO();
        $solicitudes = $solicitud->getSolicitudesByDniGuardian($dniGuard);
        if (isset($solicitudes) && !empty($solicitudes)) {
          foreach ($solicitudes as $soli) {
            if ($soli->getDniDueno() == $_SESSION["dni"]) {
              if (
                UtilsController::ValidarFecha($soli->getFechaInicio(), $soli->getFechaFin(), $fini)
                || UtilsController::ValidarFecha($soli->getFechaInicio(), $soli->getFechaFin(), $ffin)
              ) {
                return false;
              }
            }
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
    en el rango de fechas que la solicitud tiene. */
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

  /* Verifica que las mascotas no esten ya reservadas y que sean de la misma raza si el guardian 
  tuviera reserva en fecha. En caso de avanzar, borrara las solicitudes y pagos para la fecha de 
  la solicitud(futura reserva) que no sean compatibles, ya que solicitan un cuidado de mascotas de
  distinta raza al de las mascotas de esta solicitud que sera reserva. */
  public static function ValidacionesSoliPagoAReserva($arrayMascotas, $dniGuard, $idSoliRes, $fini, $ffin)
  {
    if (isset($_SESSION["loggedUser"])) {
      try {
        $valid = UtilsController::VerifMascotaNoEstaReservadaEnFecha($arrayMascotas, $fini, $ffin);
        $valid2 = UtilsController::ValidarMismaRaza($arrayMascotas, $dniGuard, $fini, $ffin);
        if ($valid && $valid2) {
          $solicitudDAO = new SolicitudDAO();
          $mascotaDAO = new  MascotaDAO();
          $mascXsoliDAO = new SolixMascDAO();
          $pagoDAO = new PagoDAO();
          $solicitudes = $solicitudDAO->getSolicitudesByDniGuardian($dniGuard);

          if (isset($solicitudes) && !empty($solicitudes)) {
            foreach ($solicitudes as $soli) {
              if ($soli->getId() != $idSoliRes) { //si no es la solicitud actual
                if (
                  UtilsController::ValidarFecha($soli->getFechaInicio(), $soli->getFechaFin(), $fini) //cambia con fmedio en validar fecha
                  || UtilsController::ValidarFecha($soli->getFechaInicio(), $soli->getFechaFin(), $ffin)
                ) { //si esta en el rango de esta futura reserva
                  $idMascota = $mascXsoliDAO->getIdMascotaByIdSolicitud($soli->getId());
                  $mascotaVerRaza = $mascotaDAO->GetById($idMascota);
                  if ($mascotaVerRaza->getRaza() != $arrayMascotas[0]->getRaza()) { //si son distinta raza
                    $mascXsoliDAO->removeSolicitudMascIntByIdSolicitud($idSoliRes); //borrar intermedia masc-soli
                    if ($soli->getEsPago()) //si la solicitud habia sido aceptada
                      $pagoDAO->removePagoById($soli->getId());

                    $solicitudDAO->removeSolicitudById($idSoliRes); //borrar solicitud
                  }
                }
              }
            }
          }
          return true;
        } else
          return false;
      } catch (Exception $ex) {
        $alert = new Alert("warning", "error en base de datos");
        UtilsController::Index($alert);
      }
    } else {
      $alert = new Alert("warning", "Debe iniciar sesion");
      UtilsController::Index($alert);
    }
  }

  /* Valida que si el usuario cambia sus datos, los unique permanezcan como unicos en toda
  la base de datos. */
  private function ValidarNuevosDatosUsuario($username = null, $email = null, $telefono = null) ///validaciones en el registro
  {
    if (isset($_SESSION["loggedUser"])) {
      try {
        if (($telefono && is_numeric($telefono)) || !$telefono) {
          $users = new UserDAO;
          $c = null;
          $b = null;
          $a = null;
          if ($users->getAll() != null) {
            if ($username)
              $a = $users->getByUsername($username);
            if ($email)
              $b = $users->getByEmail($email);
            if ($telefono) {
              $guardianDAO = new GuardianDAO();
              $duenoDAO = new DuenoDAO();
              $telefonos = array();
              $tels = $guardianDAO->getTelefonos();
              foreach ($tels as $t) {
                array_push($telefonos, $t);
              }
              $tels = $duenoDAO->getTelefonos();
              foreach ($tels as $t) {
                array_push($telefonos, $t);
              }
              foreach ($telefonos as $telef) {
                if ($telefono == $telef) {
                  $c = true;
                }
              }
            }
            if ($a != null || $b != null || $c != null)
              return false;
            else
              return true;
          }
          return true;
        } else
          return false;
      } catch (Exception $ex) {
        $alert = new Alert("warning", "error en base de datos");
        UtilsController::index($alert);
      }
    } else {
      $alert = new Alert("warning", "Debe iniciar sesion");
      UtilsController::Index($alert);
    }
  }

  /* Valida los datos de una tarjeta de credito/debito ingresada */
  public static function ValidarDatosTarjeta($numTarj, $mVenc, $aVenc, $codigo) ///validaciones en el registro
  {
    if (isset($_SESSION["loggedUser"])) {
      try {
        if (is_numeric($numTarj) && is_numeric($mVenc) && is_numeric($aVenc) && is_numeric($codigo)) {
          $tarjetas = new TarjetaDAO;
          $a = null;
          if ($tarjetas->getAll() != null) {
              $a = $tarjetas->getByNumeroTarjeta($numTarj);

            if ($a != null)
              return false;
            else
              return true;
          }
          return true;
        } else
          return false;
      } catch (Exception $ex) {
        $alert = new Alert("warning", "error en base de datos");
        UtilsController::index($alert);
      }
    } else {
      $alert = new Alert("warning", "Debe iniciar sesion");
      UtilsController::Index($alert);
    }
  }

  /* Un usuario podra cambiar alguno, todos o ninguno de los atributos que se muestran por parametro */
  public function modificarDatos($username = null, $password = null, $nombre = null, $email = null, $direccion = null, $telefono = null)
  {
    if (isset($_SESSION["loggedUser"])) {
      try {
        if ($username || $email || $telefono)
          $valid = $this->ValidarNuevosDatosUsuario($username, $email, $telefono);
        if ($valid) {
          if ($_SESSION["tipo"] == 'd') {

            $duenoDAO = new DuenoDAO();
            $dueno = $duenoDAO->GetByDni($_SESSION["dni"]);
            if (!$username)
              $username = $dueno->getUserName();
            if (!$password)
              $password = $dueno->getPassword();
            if (!$nombre)
              $nombre = $dueno->getNombre();
            if (!$email)
              $email = $dueno->getEmail();
            if (!$direccion)
              $direccion = $dueno->getDireccion();
            if (!$telefono)
              $telefono = $dueno->getTelefono();
            $duenoDAO->updateDatosDueno($username, $password, $nombre, $email, $direccion, $telefono);

            $usuarioDAO = new UserDAO();
            $usuarioDAO->updateDatosUser($username, $password, $email);

            $alert = new Alert("success", "Datos actualizados!");
            $this->loginDueno($alert);
          } else {
            ///guardian
            $guardianDAO = new GuardianDAO();
            $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
            if (!$username)
              $username = $guardian->getUserName();
            if (!$password)
              $password = $guardian->getPassword();
            if (!$nombre)
              $nombre = $guardian->getNombre();
            if (!$email)
              $email = $guardian->getEmail();
            if (!$direccion)
              $direccion = $guardian->getDireccion();
            if (!$telefono)
              $telefono = $guardian->getTelefono();

            $guardianDAO->updateDatosGuardian($username, $password, $nombre, $email, $direccion, $telefono);

            $usuarioDAO = new UserDAO();
            $usuarioDAO->updateDatosUser($username, $password, $email);

            $alert = new Alert("success", "Datos actualizados!");
            $this->LoginGuardian($alert);
          }
        } else {
          $alert = new Alert("warning", "Username, email o telefono estan utilizados por alguien mas");
          if ($_SESSION["tipo"] == 'd')
            $this->LoginDueno($alert);
          else
            $this->LoginGuardian($alert);
        }
      } catch (Exception $ex) {
        $alert = new Alert("warning", "error en base de datos");
        UtilsController::index($alert);
      }
    } else {
      $alert = new Alert("warning", "Debe iniciar sesion");
      UtilsController::Index($alert);
    }
  }
}
