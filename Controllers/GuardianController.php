<?php

namespace Controllers;

use Models\Guardian;
use DAO\GuardianDAO as GuardianDAO;

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

    public function verificar($username, $password)
    {
        require_once(VIEWS_PATH . "ControlDeAccesoGuardian.php");
    }

    public function login()
    {
        require_once(VIEWS_PATH . "loginGuardian.php");
    }
    public function registro()
    {
        require_once(VIEWS_PATH . "registroGuardian.php");
    }

    public function Add($username, $password, $nombre, $cuil, $disponibilidad, $direccion, $precio)
    {
        $guardian = new Guardian();
        $guardian->setUserName($username);
        $guardian->setPassword($password);
        $guardian->setNombre($nombre);
        $guardian->setCuil($cuil);
        $guardian->setDireccion($direccion);
        $guardian->setDisponibilidad($disponibilidad);
        $guardian->setPrecio($precio);

        $this->guardianDAO->Add($guardian);

        $this->home();
    }

    public function Remove($dni)
    {
        $this->guardianDAO->Remove($dni);

        $this->home();
    }
}
