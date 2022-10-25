<?php

namespace Controllers;

use Models\Guardian;
use Models\Alert as Alert;
use DAO\GuardianDAO as GuardianDAO;
use DAO\UserDAO as UserDAO;

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

    public function elegirDisponibilidad($desde, $hasta)
    {
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

    public function Add($username, $password, $nombre, $dni, $email, $cuil, $direccion, $precio, $tamanoMasc)
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

    public function Remove($dni)
    {
        $bien = $this->guardianDAO->Remove($dni);
        if ($bien)
            $alert = new Alert("success", "Usuario borrado exitosamente");
        else
            $alert = new Alert("warning", "Error borrando el usuario");

        $this->home($alert);
    }
}
