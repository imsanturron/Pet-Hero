<?php

namespace Controllers;

use Models\Dueno as Dueno;
use Models\Solicitud as Solicitud;
use Models\Guardian as Guardian;
use Models\Alert as Alert;
//use DAO\JSON\DuenoDAO as DuenoDAO;
use DAO\MYSQL\DuenoDAO as DuenoDAO;
//use DAO\JSON\GuardianDAO as GuardianDAO;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
//use DAO\JSON\MascotaDAO;
use DAO\MYSQL\MascotaDAO;
use DAO\MYSQL\SolicitudDAO;
use DAO\MYSQL\SolixMascDAO;
//use DAO\JSON\UserDAO as UserDAO;
use DAO\MYSQL\UserDAO as UserDAO;
use Models\SolixMasc;

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

    public function verMascotas()
    {
        require_once(VIEWS_PATH . "verMascotas.php");
    }

    public function volverAVerFechasNoUsar()
    {
        require_once(VIEWS_PATH . "filtrarPorFecha.php");
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
            } else if ($opcion == "verSolicitudes") {
                require_once(VIEWS_PATH . "verSolicitudes.php");
            } else if ($opcion == "verReservas") {
                require_once(VIEWS_PATH . "verReservas.php");
            }
        } else
            $this->home();
    }

    public function filtrarFechas($desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $valid = AuthController::ValidarFecha($desde, $hasta); //arreglar
            if ($valid) {
                //$guardianDao = new GuardianDAO();
                //$listaguardianes = $guardianDao->GetAll(); no me deja asi no se xq
                require_once(VIEWS_PATH . "verGuardianes.php");
            } else {
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
            ////$guardianes = new GuardianDAO();
            ////$guardian = new Guardian(); /////////////
            ////$guardian = $guardianes->getByDni($dni); no deja tampoco no se xq
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
        $arrayMascotas = $mascotas->getArrayByIds($animales); ///y mandar mascotas que ya tenga
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $valid = AuthController::ValidarMismaRaza($arrayMascotas, $dni, $desde, $hasta); ////////!arreglar!////+mascotas que tenga//
            $valid2 = AuthController::VerifGuardianSoliNuestraRepetida($dni); //hacer - creo q necesario
            ///ver ocupacion de mascotas y de guardianes.
            if ($valid && $valid2) {

                $guardianes = new GuardianDAO();
                $guardian = $guardianes->getByDni($dni);
                //EN ALGUN MOMENTO DE ACA AL ANIMAL HABRIA QUE AGREGARLE LA SOLICITUD

                $solicitud = new Solicitud($guardian, $_SESSION["loggedUser"], $desde, $hasta);
                $solicitudesD = new SolicitudDAO;

                $solicitudesD->Add($solicitud);
                $idSolicitud = $solicitudesD->GetIdByDniDuenoYGuardian($solicitud->getDniDueno(), $solicitud->getDniGuardian());
                ///hacer tabla solicitud x mascota -- idsxidm
                ///tamb tabla reserva x mascota -- idrxidm con estado creo
                $intermediaMascotasXsolicitud = new SolixMascDAO();
                $intermediaMascotasXsolicitud->add($arrayMascotas, $idSolicitud); //Esta funcion tendria que colocar el id de la solicitud en cada mascota que haya elegido

                $alert = new Alert("success", "Solicitud enviada!");
                $this->login($alert);
            } else {
                //cambiar alert dependiendo caso
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

    public function cancelarSolicitud($idIntermedia, $solicitudId)
    {
        $solicitud = new SolicitudDAO();
        $solicitudXmasc = new SolixMascDAO();
        $resul = $solicitud->removeSolicitudById($solicitudId);
        $resul2 = $solicitudXmasc->removeSolicitudMascIntById($idIntermedia); //!//

        if ($resul && $resul2) {
            $alert = new Alert("success", "Solicitud borrada con exito");
        } else {
            $alert = new Alert("warning", "No se borro alguna solicitud");
        }
        $this->login($alert);
    }

    ////////////////////
    public function Remove($dni)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $bien = $this->duenoDAO->removeDuenoByDni($dni);
            $bien2 = $userDAO = new UserDAO;
            $bien2 = $userDAO->removeUserByDni($dni);
            if ($bien && $bien2)
                $alert = new Alert("success", "Usuario borrado exitosamente");
            else
                $alert = new Alert("warning", "Error borrando el usuario");
            $this->home($alert);
        } else
            $this->home();
    }
}
