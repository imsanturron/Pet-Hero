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
        if ($opcion == "indicarDisponibilidad") {
            require_once(VIEWS_PATH . "indicarDisponibilidad.php");
        } else if ($opcion == "verListadReservas") {
            require_once(VIEWS_PATH . "agregarMascotas.php");
        } else if ($opcion == "verg") {
            require_once(VIEWS_PATH . "verGuardianes.php");
        }
    }

    public function elegirDisponibilidad($desde, $hasta)
    {
        $valid = AuthController::ValidarFecha($desde, $hasta);//arreglar
        if ($valid) {
            $guardian = new Guardian();
            $guardian = $_SESSION["loggedUser"];
            $guardian->setDisponibilidadInicio($desde);
            $guardian->setDisponibilidadFin($hasta);
            $bien = $this->guardianDAO->updateDisponibilidad($_SESSION["loggedUser"]->getDni(), $desde, $hasta);
            $_SESSION["loggedUser"] = $guardian;
            if($bien){
            ///alerta buena
            }
            else{
            ///alerta mala
            }
            require_once(VIEWS_PATH . "loginGuardian.php");
        } else {
            ///alerta mala
            require_once(VIEWS_PATH . "loginGuardian.php");
        }
    }

    public function Add($username, $password, $nombre, $dni, $email, $cuil, $direccion, $precio)
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
            $guardian->setPrecio($precio);

            $this->guardianDAO->Add($guardian);
            $userDAO = new UserDAO;
            $userDAO->Add($guardian);
            echo '<script>alert("Usuario creado")</script>';
            $this->home();
        } else {
            echo '<script>alert("Usuario ya existente")</script>';
            $this->home();
        }
    }

    public function Remove($dni)
    {
        $this->guardianDAO->Remove($dni);

        $this->home();
    }
}
