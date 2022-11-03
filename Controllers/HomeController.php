<?php

namespace Controllers;

class HomeController
{
    public function Index($message = "")
    {
        require_once(VIEWS_PATH . "home.php");
    }

    /* Llega un una variable php usuario en el post con valor dueño o guardian y los envia a su home*/
    public function validarTipoDeUsuario($usuario)
    {
        $usuario = $_POST['usuario'];

        if ($usuario == "login") {
            require_once(VIEWS_PATH . "login.php");
        } else if ($usuario == "Registrarseguardian") {
            require_once(VIEWS_PATH . "registroGuardian.php");
        } else {
            require_once(VIEWS_PATH . "registroDueno.php");
        }
    }

    /*public function verMascotasSoliRes($idSolicitud)
    {
        if (isset($_SESSION["loggedUser"]))
            require_once(VIEWS_PATH . "registroGuardian.php");
        else
            $this->Index();
    }*/
}
