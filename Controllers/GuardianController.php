<?php

namespace Controllers;

use Models\Guardian;
use Models\Alert as Alert;
use Models\Solicitud as Solicitud;
use DAO\GuardianDAO as GuardianDAO;
use DAO\UserDAO as UserDAO;
use Models\Reserva as Reserva;

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
        if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"] == "g") {
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
                require_once(VIEWS_PATH . "verSolicitudes.php");
            }
        }
    }

    public function elegirDisponibilidad($desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"] == "g") {
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
        }
        $this->home();
    }

    public function operarSolicitud($solicitudId, $operacion)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"]->getTipo() == "g") {
            if ($operacion == "aceptar") {
                $soli = $_SESSION["loggedUser"]->getSolicitudById($solicitudId);
                $reserva = new Reserva($soli);
                $_SESSION["loggedUser"]->addReserva($reserva);
                $_SESSION["loggedUser"]->unsetSolicitud($solicitudId);
                ///********///
                $alert = new Alert("success", "Solicitud aceptada");
            } else if ($operacion == "rechazar") {
                $_SESSION["loggedUser"]->unsetSolicitud($solicitudId);
                $alert = new Alert("success", "Solicitud cancelada");
            }
            $this->login($alert);
        }
        $alert = new Alert("warning", "Hubo un error");
        $this->login($alert);
    }

    public function Add($username, $password, $nombre, $dni, $email, $cuil, $direccion, $precio, $tamanoMasc)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"] == "g") {
            $valid = AuthController::ValidarUsuario($username, $dni, $email);
            if ($valid) {
                $guardian = new Guardian();
                $guardian->setUserName($username);
                $guardian->setPassword($password);
                $guardian->setNombre($nombre);
                $guardian->setDni($dni);
                $guardian->setCuil($cuil);
                $guardian->setEmail($email);
                $guardian->setDireccion($direccion);
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
        $this->home();
    }

    public function Remove($dni)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["loggedUser"] == "g") {
        $bien = $this->guardianDAO->Remove($dni);
        if ($bien)
            $alert = new Alert("success", "Usuario borrado exitosamente");
        else
            $alert = new Alert("warning", "Error borrando el usuario");

        $this->home($alert);
        }
        $this->home();
    }
}
