<?php

namespace Controllers;

use Models\Dueno as Dueno;
use DAO\DuenoDAO as DuenoDAO;
use DAO\UserDAO as UserDAO;

class DuenoController
{
    private $duenoDAO;

    public function __construct()
    {
        $this->duenoDAO = new DuenoDAO();
    }

    public function opcionMenuPrincipal($opcion)
    {
        $opcion = $_POST['opcion'];

        if ($opcion == "verm") {
            require_once(VIEWS_PATH . "verMascotas.php");
        } else if ($opcion == "agregarm") {
            require_once(VIEWS_PATH . "agregarMascotas.php");
        } else if ($opcion == "verg") {
            require_once(VIEWS_PATH . "verGuardianes.php");
        }
    }

    public function home()
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function ElegirG()
    {
        //require_once(VIEWS_PATH . "ver como seguirlo.php");
        require_once(VIEWS_PATH . "home.php");
    }

    public function login()
    {
        require_once(VIEWS_PATH . "loginDueno.php");
    }

    public function registro()
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
            $this->home();
        } else {
            ///alerta
            $this->home();
        }
    }

    ////////////////////
    public function Remove($dni)
    {
        $this->duenoDAO->Remove($dni);

        $this->home();
    }
}
