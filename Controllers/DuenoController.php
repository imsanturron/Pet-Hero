<?php

namespace Controllers;

use Models\Dueno as Dueno;
use DAO\DuenoDAO as DuenoDAO;
<<<<<<< HEAD
=======
use DAO\UserDAO as UserDAO;
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7

class DuenoController
{
    private $duenoDAO;

    public function __construct()
    {
        $this->duenoDAO = new DuenoDAO();
    }

<<<<<<< HEAD
    public function verificar($username, $password)
    {
        require_once(VIEWS_PATH . "ControlDeAccesoDueno.php");
    }
//recibe la respuesta del form(loginDueno.php) y dependiendo cual sea la opcion seleccionada te redirecciona al php pertinente*/
=======
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
    public function opcionMenuPrincipal($opcion)
    {
        $opcion = $_POST['opcion'];

<<<<<<< HEAD
        if ($opcion == "verm") {
            require_once(VIEWS_PATH . "verMascotas.php");
        } else if ($opcion == "agregarm"){
            require_once(VIEWS_PATH . "agregarMascotas.php");
        } else if($opcion == "verg"){
=======
        if ($opcion == "verMascotas") {
            require_once(VIEWS_PATH . "verMascotas.php");
        } else if ($opcion == "agregarMascota") {
            require_once(VIEWS_PATH . "agregarMascotas.php");
        } else if ($opcion == "verGuardianes") {
            //$listaguardianes=$this->duenoDAO->getAll();
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
            require_once(VIEWS_PATH . "verGuardianes.php");
        }
    }

    public function home()
    {
        require_once(VIEWS_PATH . "home.php");
    }

<<<<<<< HEAD
=======
    public function ElegirGuardian()
    {
        //require_once(VIEWS_PATH . "ver como seguirlo.php");
        require_once(VIEWS_PATH . "home.php");
    }

>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
    public function login()
    {
        require_once(VIEWS_PATH . "loginDueno.php");
    }

    public function registro()
    {
        require_once(VIEWS_PATH . "registroDueno.php");
    }

<<<<<<< HEAD
    public function Add($username, $password, $nombre, $dni, $direccion, $telefono)
    {
        $dueno = new Dueno();
        $dueno->setUserName($username);
        $dueno->setPassword($password);
        $dueno->setNombre($nombre);
        $dueno->setDni($dni);
        $dueno->setDireccion($direccion);
        $dueno->setTelefono($telefono);

        $this->duenoDAO->Add($dueno);

        $this->home();
    }

    public function Remove($dni)
    {
        $this->duenoDAO->Remove($dni);

        $this->home();
    }
}
=======
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
            ///alerta buena
            $this->home();
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
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
