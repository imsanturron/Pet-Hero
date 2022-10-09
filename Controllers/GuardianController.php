<?php

namespace Controllers;

use Models\Guardian;
use DAO\GuardianDAO as GuardianDAO;
use DAO\UserDAO as UserDAO;

class GuardianController
{
    private $guardianDAO;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
    }

    public function home()
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function login()
    {
        require_once(VIEWS_PATH . "loginGuardian.php");
    }
    public function registro()
    {
        require_once(VIEWS_PATH . "registroGuardian.php");
    }

    public function opcionMenuPrincipal($opcion)
    {
        $opcion = $_POST['opcion'];

        if ($opcion == "indicarDispEstd") {
            require_once(VIEWS_PATH . "indicarDispEstd.php");
        } else if ($opcion == "verListadReservas") {
            require_once(VIEWS_PATH . "agregarMascotas.php");
        } else if ($opcion == "verg") {
            require_once(VIEWS_PATH . "verGuardianes.php");
        }
    }

    public function elegirDisponibilidad($desde,$hasta){

        


    }

    public function Add($username, $password, $nombre, $dni, $email, $cuil, $disponibilidad, $direccion, $precio)
    {
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
            $guardian->setDisponibilidad($disponibilidad);
            $guardian->setPrecio($precio);

            $this->guardianDAO->Add($guardian);
            $userDAO = new UserDAO;
            $userDAO->Add($guardian);
            $this->home();
        } else {
            ///alerta-----------
            $this->home();
        }
    }

    public function Remove($dni)
    {
        $this->guardianDAO->Remove($dni);

        $this->home();
    }
}
