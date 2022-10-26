<?php

namespace Controllers;

use Models\Dueno as Dueno;
use Models\Solicitud as Solicitud;
use Models\Guardian as Guardian;
use Models\Alert as Alert;
use DAO\DuenoDAO as DuenoDAO;
use DAO\GuardianDAO as GuardianDAO;
use DAO\MascotaDAO;
use DAO\UserDAO as UserDAO;

class DuenoController
{
    private $duenoDAO;

    public function __construct()
    {
        $this->duenoDAO = new DuenoDAO();
    }

    public function Index($message = "")
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function opcionMenuPrincipal($opcion)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $opcion = $_POST['opcion'];

            if ($opcion == "verMascotas") {
                require_once(VIEWS_PATH . "verMascotas.php");
            } else if ($opcion == "agregarMascota") {
                require_once(VIEWS_PATH . "agregarMascotas.php");
            } else if ($opcion == "verGuardianes") {
                //$listaguardianes=$this->duenoDAO->getAll();
                //require_once(VIEWS_PATH . "verGuardianes.php");
                require_once(VIEWS_PATH . "filtrarPorFecha.php");
            } else if ($opcion == "verPerfil") {
                ///sin terminar
                require_once(VIEWS_PATH . "perfilDueno.php");
            }
        } else
            $this->home();
    }

    public function filtrarFechas($desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $valid = AuthController::ValidarFecha($desde, $hasta); //arreglar
            if ($valid)
                require_once(VIEWS_PATH . "verGuardianes.php");
            else {
                $alert = new Alert("warning", "Fecha invalida");
                $this->login($alert);
            }
        } else
            $this->home();
    }

    public function home(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function ElegirGuardian($dni, $desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $guardianes = new GuardianDAO();
            //$guardian = new Guardian(); /////////////
            $guardian = $guardianes->getByDni($dni);
            require_once(VIEWS_PATH . "solicitarCuidadoMasc.php");
            //$guardianes->remove($guardian);// DESCOMENTAR CUANDO PUEDA RETORNAR SOLICITUDES
            //$solicitud = new Solicitud($desde, $hasta);
            //$guardianes->addSolicitudDao($solicitud, $dni); //*****************//
            //$guardian->addSolicitud($solicitud);
            //$solicitudes=$guardian->getSolicitudes();//ME CREA ARREGLOS VACIOS DENTRO DEL ARREGLO
            //$guardianes->add($guardian);
            //$this->login();
        } else
            $this->home();
    }

    public function ElegirGuardianFinal($animales, $dni, $desde, $hasta)
    {
        $mascotas = new MascotaDAO();
        //print_r($animales);
        $arrayMascotas = array();
        $arrayMascotas = $mascotas->getArrayByIds($animales);
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $valid = AuthController::ValidarMismaRaza($arrayMascotas); ////////!arreglar!///////////
            if ($valid) {
                $guardianes = new GuardianDAO();
                $solicitud = new Solicitud($arrayMascotas, $desde, $hasta);
                //print_r($solicitud);
                $guardianes->addSolicitudDao($solicitud, $dni); //*****************//
                $alert = new Alert("success", "Solicitud enviada!");
                $this->login($alert);
            } else {
                $alert = new Alert("warning", "Hubo un error");
                $this->login($alert);
            }
        } else
            $this->home();
    }

    public function login(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "loginDueno.php");
    }

    public function registro(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "registroDueno.php");
    }

    public function Add($username, $password, $nombre, $dni, $email, $direccion, $telefono)
    {
        $valid = AuthController::ValidarUsuario($username, $dni, $email);
        if ($valid) {
            $dueno = new Dueno();
            $dueno->setUserName($username);
            $dueno->setPassword($password);
            $dueno->setNombre($nombre);
            $dueno->setDni($dni);
            $dueno->setEmail($email);
            $dueno->setDireccion($direccion);
            $dueno->setTelefono($telefono);

            $this->duenoDAO->Add($dueno);
            $userDAO = new UserDAO;
            $userDAO->add($dueno);

            $alert = new Alert("success", "Usuario creado");
            $this->home($alert);
        } else {
            $alert = new Alert("warning", "Error! Usuario ya existente");
            $this->home($alert);
        }
    }

    ////////////////////
    public function Remove($dni)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $bien = $this->duenoDAO->Remove($dni);
            if ($bien)
                $alert = new Alert("success", "Usuario borrado exitosamente");
            else
                $alert = new Alert("warning", "Error borrando el usuario");

            $this->home($alert);
        } else
            $this->home();
    }
}
