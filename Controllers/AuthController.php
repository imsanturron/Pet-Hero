<?php

namespace Controllers;

//use DAO\JSON\GuardianDAO as GuardianDao;
use DAO\MYSQL\GuardianDAO as GuardianDao;
//use DAO\JSON\DuenoDAO as DuenoDAO;
use DAO\MYSQL\DuenoDAO as DuenoDAO;
use DAO\MYSQL\MascotaDAO;
use DAO\MYSQL\ReservaDAO;
use DAO\MYSQL\ResxMascDAO;
use DAO\MYSQL\SolicitudDAO;
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

  public function Login($username, $password)
  {
    try {
      $users = new UserDAO;
      $tipo = $users->getTipoByUsername($username);
      //print_r($tipo);
      $bool = false;

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
            ///alerta buena
            require_once(VIEWS_PATH . "loginDueno.php");
          } else {
            $alert = new Alert("warning", "Fecha invalida");
            $this->Index($alert);
          }
        }
      }
    } catch (Exception $e) {
      $alert = new Alert("warning", "datos incorrectos");
    }
    if ($bool == false) {
      $alert = new Alert("warning", "Fecha invalida");
      $this->Index($alert);
    }
  }

  /*private function validacionesLogin() //agrandar luego con pagos
  {
    $bool = false; //actualizar adentro
    if (isset($_SESSION["loggedUser"])) {
      if ($_SESSION["tipo"] == 'g') {
        $guardian = new Guardian();
        $guardian = $_SESSION["loggedUser"];
        //$solicitud = new SolicitudDAO();
        //$solicitudes = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());
        if(AuthController::ValidarFecha($guardian->getDisponibilidadFin())){
          ///borrar todas las solicitudes, las solis intermedias y setear en null
          //la disponibilidad
        } else if(AuthController::ValidarFecha($guardian->getDisponibilidadInicio())){
            ///ver que solicitudes, y solis intermedias hay que borrar
            //y advertir que la fecha inicio se paso
        }
        //chequear reservas para cambiarles el estado
      } else {
        //caso dueño
        $dueno = new Dueno();
        $dueno = $_SESSION["loggedUser"];
        $solicitud = new SolicitudDAO();
        $solicitudes = $solicitud->getSolicitudesByDniDueno($dueno->getDni());
        foreach($solicitudes as $soli){
          if(AuthController::ValidarFecha($soli->getFechaInicio)){
             //remover solicitud
          }
        }
        //chequear reservas para cambiarles el estado
      }
    }
    return $bool;
  }*/

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
      var_dump($ffin);
      var_dump($fmedio);
      var_dump($despDeHoy);
    if ($ffin && $fmedio = null && $despDeHoy == false) { ///verificar si fini es antes de ff
      //echo "acaa";
      if (strtotime($fini) <= strtotime($ff))
        return true;
      else
        return false;
    } else if ($ffin == null && $fmedio = null) {
      if (strtotime($fini) >= strtotime(date("Y-m-d"))) ///verificar que fini mayor que hoy
        return true;
      else
        return false;
    } else if ($ffin && $fmedio = null && $despDeHoy == true) { //primer if + fini despues de hoy
      if (strtotime($fini) >= strtotime(date("Y-m-d")) && strtotime($fini) <= strtotime($ff))
        return true;
      else
        return false;
    } else if ($ffin && $fmedio && $despDeHoy == false) {//verificar que $fmedio->$fmed esta entre $fini y $ff
      if (strtotime($fini) <= strtotime($ff)
           && strtotime($fini) <= strtotime($fmed)
             && strtotime($fmed) <= strtotime($ff))
             return true;
             else
             return false;
    } else if ($ffin && $fmedio && $despDeHoy == true){ //anterior if + fini >= hoy
      if (strtotime($fini) >= strtotime(date("Y-m-d"))
        && strtotime($fini) <= strtotime($ff)
          && strtotime($fini) <= strtotime($fmed)
            && strtotime($fmed) <= strtotime($ff))
              return true;
            else
              return false;
    }
    //echo "acaa";
*/
    //var_dump(strtotime(date("Y-m-d")));
    //var_dump($ff);
    /*if (strtotime($ff) >= strtotime(date("Y-m-d")))
      echo 1;
    else
      echo 0;*/
    //var_dump(date("Y-m-d"));

    $fini = explode("-", $finic);
    if ($ffin)
      $ff = explode("-", $ffin);

    if ($ffin && $despDeHoy == false) {

      if ($fini[0] < $ff[0])
        return true;
      else if ($fini[0] == $ff[0] && $fini[1] < $ff[1])
        return true;
      elseif ($fini[0] == $ff[0] && $fini[1] == $ff[1] && $fini[2] <= $ff[2])
        return true;
      else
        return false;
    } else if ($ffin == null) {

      $fechaHoy = date("Y-m-d", strtotime("now"));
      $compar = explode("-", $fechaHoy); ///echo $compar[3];
      if ($compar[0] < $fini[0])
        return true;
      else if ($compar[0] == $fini[0] && $compar[1] < $fini[1])
        return true;
      elseif ($compar[0] == $fini[0] && $compar[1] == $fini[1] && $compar[2] <= $fini[2])
        return true;
      else
        return false;
      ///seguir caso de las 2 fechas y verificar este
    } else if ($ffin && $despDeHoy == true) {
      return true;
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

  /*public static function VerifMascotaNoEstaReservadaEnFecha($arrayMascotas, $fini, $ffin){
    $reservaXmascotas = new ResxMascDAO();
    $resXmasc = $reservaXmascotas->GetAll();
    $reserva = new ReservaDAO();

    foreach($arrayMascotas as $masc){
      foreach($resXmasc as $rmi){
        if($rmi->getIdMascota() == $masc->getId()){
          $res =  $reserva->GetById($rmi->getIdReserva());
          if((AuthController::ValidarFecha($res->getFechaInicio(), $fini) //cambia con fmedio en validar fecha
              && AuthController::ValidarFecha($ffin, $res->getFechaFin()))){
               return false; //la mascota esta reservada en esa fecha
          }
        }
      }
    }
    return true;
  }*/

  public function Logout()
  {
    session_destroy();
    $this->Index();
  }
}
