<?php

namespace Controllers;

use Models\Dueno as Dueno;
use Models\Alert as Alert;
use DAO\DuenoDAO as DuenoDAO;
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
        $opcion = $_POST['opcion'];

        if ($opcion == "verMascotas") {
            require_once(VIEWS_PATH . "verMascotas.php");
        } else if ($opcion == "agregarMascota") {
            require_once(VIEWS_PATH . "agregarMascotas.php");
        } else if ($opcion == "verGuardianes") {
            //$listaguardianes=$this->duenoDAO->getAll();
            require_once(VIEWS_PATH . "verGuardianes.php");
        }else if ($opcion == "verPerfil") {
            ///sin terminar
            require_once(VIEWS_PATH . "perfilDueno.php");
        }
    }

    public function home(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function ElegirGuardian()
    {
        //require_once(VIEWS_PATH . "ver como seguirlo.php");
        require_once(VIEWS_PATH . "home.php");
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
            $userDAO->Add($dueno);
            $alert = new Alert();
            $alert->setTipo("success");
            $alert->setMensaje("logueado correctaametn");
            $this->home($alert);
        } else {
            ///alerta mala
            $this->home();
        }
    }

    ////////////////////
    public function Remove($dni)
    {
        $this->duenoDAO->Remove($dni);
        ///alerta buena
        $this->home();
    }
}