<?php

namespace Controllers;

use Models\Guardian;
use Models\Alert as Alert;
use Models\Solicitud as Solicitud;
use Models\Reserva as Reserva;
//use DAO\JSON\GuardianDAO as GuardianDAO;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\SolicitudDAO;
//use DAO\JSON\UserDAO as UserDAO;
use DAO\MYSQL\UserDAO as UserDAO;
use DAO\MYSQL\ReservaDAO as ReservaDAO;
use DAO\MYSQL\SolixMascDAO as SolixMascDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\ResxMascDAO as ResxMascDAO;

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
    public function verReservas(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "verReservas.php");
    }
    public function verSolicitudes(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "verSolicitudes.php");
    }

    public function opcionMenuPrincipal($opcion)
    {
        ///alerta de disponibilidad obsoleta?
        ///checkear reservas que venzan en fecha
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            ///cambiar tamaño mascota a cuidar
            $opcion = $_POST['opcion'];
            if ($opcion == "indicarDisponibilidad") {
                require_once(VIEWS_PATH . "indicarDisponibilidad.php");
            } else if ($opcion == "verListadReservas") {
                require_once(VIEWS_PATH . "verReservas.php");
            } else if ($opcion == "verPerfil") {
                ///sin terminar
                require_once(VIEWS_PATH . "perfilGuardian.php");
            } else if ($opcion == "verSolicitudes") {
                $solicitudes = new SolicitudDAO;
                $solis = $solicitudes->GetAll(); ///get all by id desp
                require_once(VIEWS_PATH . "verSolicitudes.php");
            }
        }
    }

    public function elegirDisponibilidad($desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
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
                    //////////
                    $solicitud = new SolicitudDAO(); //borrar solicitudes que no estan en mi nuevo rango disponible
                    $solicitudes = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());
                    foreach($solicitudes as $soli){
                        if(AuthController::ValidarFecha($soli->getFechaInicio(), $desde)
                            || AuthController::ValidarFecha($hasta, $soli->getFechaFin())){
                                 $solicitud->removeSolicitudById($soli->getId()); //creo q bien, checkear
                            }
                    }
                    /////////
                } else {
                    $alert = new Alert("warning", "Error actualizando disponibilidad");
                }
                $this->login($alert);
            } else {
                $alert = new Alert("warning", "La fecha seleccionada es invalida");
                $this->login($alert);
            }
        } else
            $this->home();
    }

    public function operarSolicitud($idIntermedia, $animales, $solicitudId, $operacion)
    {
        echo "echo de id de la intermedia: " . $idIntermedia . "<br><br>";
        echo "animales-->  ";
        print_r($animales);
        $mascotas = new MascotaDAO();
        $arrayMascotas = $mascotas->getArrayByIds($animales);
        echo "mascotas-->  ";
        print_r($mascotas);

        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            if ($operacion == "aceptar") {
                $solicitud = new SolicitudDAO();
                $solicitudXmasc = new SolixMascDAO();

                $soli = $solicitud->GetById($solicitudId);
                //var_dump($soli);
                $reserva = new Reserva($soli); 
                $reservaDAO = new ReservaDAO();
                $reservaDAO->add($reserva); ///pareciera que llega vacio
                $resul = $solicitud->removeSolicitudById($solicitudId);
                $resul2 = $solicitudXmasc->removeSolicitudMascIntById($idIntermedia); //!//
                $intermediaMascotasXreserva = new ResxMascDAO();
                $intermediaMascotasXreserva->add($arrayMascotas, $solicitudId);
                ///********///
                if ($resul && $resul2) {
                    $alert = new Alert("success", "Solicitud aceptada");
                } else {
                    $alert = new Alert("warning", "No se borro alguna solicitud");
                }
            } else if ($operacion == "rechazar") {

                $solicitud = new SolicitudDAO();
                $solicitudXmasc = new SolixMascDAO();
                $resul = $solicitud->removeSolicitudById($solicitudId);
                $resul2 = $solicitudXmasc->removeSolicitudMascIntById($idIntermedia); //!//

                if ($resul && $resul2) {
                    $alert = new Alert("success", "Solicitud borrada con exito");
                } else {
                    $alert = new Alert("warning", "No se borro alguna solicitud");
                }
            }
            $this->login($alert);
        }
        $alert = new Alert("warning", "Hubo un error");
        $this->login($alert);
    }

    public function Add($username, $password, $nombre, $dni, $email, $direccion, $telefono, $precio, $tamanoMasc)
    {
        $valid = AuthController::ValidarUsuario($username, $dni, $email);
        if ($valid) {
            $guardian = new Guardian();
            $guardian->setUserName($username);
            $guardian->setPassword($password);
            $guardian->setNombre($nombre);
            $guardian->setDni($dni);
            $guardian->setEmail($email);
            $guardian->setDireccion($direccion);
            $guardian->setTelefono($telefono);
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
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            $bien = $this->guardianDAO->removeGuardianByDni($dni);
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
