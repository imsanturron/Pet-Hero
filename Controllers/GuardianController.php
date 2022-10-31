<?php

namespace Controllers;

use Models\Guardian;
use Models\Alert as Alert;
use Models\Solicitud as Solicitud;
use Models\Reserva as Reserva;
//use DAO\JSON\GuardianDAO as GuardianDAO;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\SolicitudDAO;
//use DAO\JSON\UserDAO as UserDAO;
use DAO\MYSQL\UserDAO as UserDAO;
use DAO\MYSQL\ReservaDAO as ReservaDAO;

class GuardianController
{
    private $guardianDAO;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
    }

    public function Index($message = "")
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function home(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function login(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "loginGuardian.php");
    }
    public function registro(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "registroGuardian.php");
    }

    public function opcionMenuPrincipal($opcion)
    {
        ///alerta de disponibilidad obsoleta?
        ///checkear reservas que venzan en fecha
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            ///cambiar tamaño mascota a cuidar
            $opcion = $_POST['opcion'];
            if ($opcion == "indicarDisponibilidad") {
                require_once(VIEWS_PATH . "indicarDisponibilidad.php");
            } else if ($opcion == "verListadReservas") {
                require_once(VIEWS_PATH . "loginGuardian.php");
            } else if ($opcion == "verPerfil") {
                ///sin terminar
                require_once(VIEWS_PATH . "perfilGuardian.php");
            } else if ($opcion == "verSolicitudes") {
                $solicitudes = new SolicitudDAO;
                $solis = $solicitudes->GetAll(); ///get all by id desp
                require_once(VIEWS_PATH . "verSolicitudes.php");
            }
        }
    }

    public function elegirDisponibilidad($desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            $valid = AuthController::ValidarFecha($desde, $hasta); //arreglar
            if ($valid) {
                $guardian = new Guardian();
                $guardian = $_SESSION["loggedUser"];
                $guardian->setDisponibilidadInicio($desde);
                $guardian->setDisponibilidadFin($hasta);
                $bien = $this->guardianDAO->updateDisponibilidad($_SESSION["loggedUser"]->getDni(), $desde, $hasta);
                $_SESSION["loggedUser"] = $guardian;
                if ($bien) {
                    $alert = new Alert("success", "Disponibilidad actualizada");
                } else {
                    $alert = new Alert("warning", "Error actualizando disponibilidad");
                }
                $this->login($alert);
            } else {
                $alert = new Alert("warning", "La fecha seleccionada es invalida");
                $this->login($alert);
            }
        } else
            $this->home();
    }

    public function operarSolicitud($solicitudId, $operacion)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            if ($operacion == "aceptar") {
                $solicitud = new SolicitudDAO();
               // $soli = $_SESSION["loggedUser"]->getSolicitudById($solicitudId);
               
               $soli = $solicitud->GetById($solicitudId);
               $reserva = new Reserva($soli);
               $reservaDAO = new ReservaDAO();
               $reservaDAO->add($reserva);
               $resul=$solicitud->removeSolicitud($solicitudId);
                ///********///
                if($resul){
                $alert = new Alert("success", "Solicitud aceptada");
                }else{
                    $alert = new Alert("warning", "No se borro la solicitud");
                }
            } else if ($operacion == "rechazar") {
               
                $solicitud = new SolicitudDAO();
                $resul=$solicutud->removeSolicitud($solicitudId);
              
                if($resul){
                    $alert = new Alert("success", "Solicitud borrada con exito");
                    }else{
                        $alert = new Alert("warning", "No se borro la solicitud");
                    }
            }
            $this->login($alert);
        }
        $alert = new Alert("warning", "Hubo un error");
        $this->login($alert);
    }

    public function Add($username, $password, $nombre, $dni, $email, $direccion, $telefono, $precio, $tamanoMasc)
    {
        $valid = AuthController::ValidarUsuario($username, $dni, $email);
        if ($valid) {
            $guardian = new Guardian();
            $guardian->setUserName($username);
            $guardian->setPassword($password);
            $guardian->setNombre($nombre);
            $guardian->setDni($dni);
            $guardian->setEmail($email);
            $guardian->setDireccion($direccion);
            $guardian->setTelefono($telefono);
            $guardian->setPrecio($precio);
            $guardian->setTamanoACuidar($tamanoMasc);

            $this->guardianDAO->add($guardian);
            $userDAO = new UserDAO;
            $userDAO->Add($guardian);
            $alert = new Alert("success", "Usuario creado");
            $this->home($alert);
        } else {
            $alert = new Alert("warning", "Error! Este usuario ya existe");
            $this->home($alert);
        }
    }

    /*public function Remove($dni)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            $bien = $this->guardianDAO->Remove($dni);
            if ($bien)
                $alert = new Alert("success", "Usuario borrado exitosamente");
            else
                $alert = new Alert("warning", "Error borrando el usuario");

            $this->home($alert);
        } else
            $this->home();
    }*/
}
