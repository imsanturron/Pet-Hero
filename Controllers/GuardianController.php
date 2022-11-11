<?php

namespace Controllers;

use Models\Guardian;
use Models\Alert as Alert;
use Models\Solicitud as Solicitud;
use Models\Reserva as Reserva;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\SolicitudDAO;
use DAO\MYSQL\UserDAO as UserDAO;
use DAO\MYSQL\ReservaDAO as ReservaDAO;
use DAO\MYSQL\SolixMascDAO as SolixMascDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\ResxMascDAO as ResxMascDAO;
use DAO\MYSQL\PagoDAO as PagoDAO;
use Models\Pago as pago;

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
        $guardian = $_SESSION['loggedUser'];
        $reservas = new ReservaDAO();
        $ress = $reservas->getReservasByDniGuardian($guardian->getDni());
        $mascota = new MascotaDAO(); ///get all by id desp
        $mascotas = $mascota->GetAll(); ///get all by id desp
        $resXmascDAO = new ResxMascDAO();
        $mascXres = $resXmascDAO->GetAll();
        require_once(VIEWS_PATH . "verReservas.php");
    }

    public function verSolicitudes(Alert $alert = null)
    {
        $guardian = $_SESSION['loggedUser'];
        $solicitudes = new SolicitudDAO();
        $solis = $solicitudes->getSolicitudesByDniGuardian($guardian->getDni());
        $mascota = new MascotaDAO(); ///get all by id desp
        $mascotas = $mascota->GetAll(); ///get all by id desp
        //$mascotas = $mascota->getMascotasByIdSolicitud();
        $mascXsoliDAO = new SolixMascDAO();
        $mascXsoli = $mascXsoliDAO->GetAll();
        require_once(VIEWS_PATH . "verSolicitudes.php");
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

    public function opcionMenuPrincipal($opcion) ///cambiar tamaño mascota a cuidar
    {
        ///alerta de disponibilidad obsoleta?
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            $opcion = $_POST['opcion'];
            if ($opcion == "indicarDisponibilidad") {
                require_once(VIEWS_PATH . "indicarDisponibilidad.php");

            } else if ($opcion == "verListadReservas") {
                $guardian = $_SESSION['loggedUser'];
                $reservas = new ReservaDAO();
                $ress = $reservas->getReservasByDniGuardian($guardian->getDni());
                $mascota = new MascotaDAO(); ///get all by id desp
                $mascotas = $mascota->GetAll(); ///get all by id desp
                $resXmascDAO = new ResxMascDAO();
                $mascXres = $resXmascDAO->GetAll();
                require_once(VIEWS_PATH . "verReservas.php");

            } else if ($opcion == "verPerfil") {
                ///sin terminar
                require_once(VIEWS_PATH . "perfilGuardian.php");

            } else if ($opcion == "verSolicitudes") {
                $envio = array();
                $guardian = $_SESSION['loggedUser'];
                $solicitudes = new SolicitudDAO();
                $solis = $solicitudes->getSolicitudesByDniGuardian($guardian->getDni());
                $mascota = new MascotaDAO(); ///get all by id desp
                $mascotas = $mascota->GetAll(); ///get all by id desp
                //$mascotas = $mascota->getMascotasByIdSolicitud();
                $mascXsoliDAO = new SolixMascDAO();
                $mascXsoli = $mascXsoliDAO->GetAll();
                foreach ($solis as $solicitud) {
                    if ($solicitud->getEsPago() == false || $solicitud->getEsPago() == null) {
                        array_push($envio, $solicitud);
                    }
                }
                $solis = $envio;
                require_once(VIEWS_PATH . "verSolicitudes.php");

            } else if ($opcion == "verPrimerosPagosPendientes") {
                $guardian = $_SESSION['loggedUser'];
                $pago = new PagoDAO();
                $solicitud = new SolicitudDAO();
                $solis = $solicitud->getSolicitudesByDniGuardian($guardian->getDni()); ///get all by id desp
                $pagos = $pago->getPagosByDniGuardian($guardian->getDni());
                $mascXsoliDAO = new SolixMascDAO();
                $mascXsoli = $mascXsoliDAO->GetAll();
                $mascXresDAO = new ResxMascDAO();
                $mascXres = $mascXresDAO->GetAll();
                $mascota = new MascotaDAO(); ///get all by id desp
                $mascotas = $mascota->GetAll(); ///get all by id desp
                $reservas = new ReservaDAO();
                $ress = $reservas->getReservasByDniGuardian($guardian->getDni());
                require_once(VIEWS_PATH . "pagosPendientes.php");

            } else if ($opcion == "cambiarTamanoACuidar") {
                $guardian = $_SESSION["loggedUser"];
                require_once(VIEWS_PATH . "cambiarTamanoACuidar.php");
            }
        }
    }

    public function elegirDisponibilidad($desde, $hasta, $noDisp = null)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            if ($noDisp) {
                $guardianDAO = new GuardianDAO();
                $guardian = new Guardian();
                $guardian = $_SESSION["loggedUser"];
                $soliXmasc = new SolixMascDAO();
                $pagoDAO = new PagoDAO();
                $solicitud = new SolicitudDAO();
                $solicitudesABorrar = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());

                if (isset($solicitudesABorrar)) {
                    foreach ($solicitudesABorrar as $soli) {  //borrar intermedias
                        $soliXmasc->removeSolicitudMascIntByIdSolicitud($soli->getId());
                        if ($soli->getEsPago())
                            $pagoDAO->removePagoById($soli->getId());
                    }
                    $solicitud->removeSolicitudesByDniGuardian($guardian->getDni());
                }
                $guardianDAO->setDisponibilidadEnNull($guardian->getDni());
                //alerta
                $this->login();
            } else {
                $valid = UtilsController::ValidarFecha($desde, $hasta); //arreglar
                if ($valid) {
                    $guardian = new Guardian();
                    $guardian = $_SESSION["loggedUser"];
                    $bien = $this->guardianDAO->updateDisponibilidad($guardian->getDni(), $desde, $hasta);
                    if ($bien) {
                        $alert = new Alert("success", "Disponibilidad actualizada");
                        $solicitud = new SolicitudDAO(); //borrar solicitudes que no estan en mi nuevo rango disponible
                        $solicitudes = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());
                        $solicitudXmasc = new SolixMascDAO();
                        $pagoDAO = new PagoDAO();
                        foreach ($solicitudes as $soli) {
                            if (
                                !UtilsController::ValidarFecha($desde, $hasta, $soli->getFechaInicio())
                                || !UtilsController::ValidarFecha($desde, $hasta, $soli->getFechaFin())
                            ) {
                                if ($soli->getEsPago())
                                    $pagoDAO->removePagoById($soli->getId());

                                $solicitudXmasc->removeSolicitudMascIntByIdSolicitud($soli->getId());
                                $solicitud->removeSolicitudById($soli->getId()); //creo q bien, checkear
                                $alert = new Alert("success", "Disponibilidad actualizada + solis removidas");
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
            }
        } else
            $this->home();
    }

    public function cambiarTamanoAResguardar($tamanoMasc) //el tamaño sera siempre distinto al anterior
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            $guardian = new Guardian();
            $guardian = $_SESSION["loggedUser"];
            $guardianDAO = new GuardianDAO();
            $guardianDAO->updateTamanoACuidar($guardian->getDni(), $tamanoMasc);
            $solicitudDAO = new SolicitudDAO();
            $soliXmasc = new SolixMascDAO();
            $pagoDAO = new PagoDAO();

            $solicitudes = $solicitudDAO->getSolicitudesByDniGuardian($guardian->getDni());
            if (isset($solicitudes)) {
                foreach ($solicitudes as $soli) {  //borrar intermedias
                    $soliXmasc->removeSolicitudMascIntByIdSolicitud($soli->getId());
                    if ($soli->getEsPago())
                        $pagoDAO->removePagoById($soli->getId());
                }
                $solicitudDAO->removeSolicitudesByDniGuardian($guardian->getDni()); //borrar todas las solis de tamaño viejo
                ////ver distinto tamaño en mascotas a cuidar
            }
        } else
            $this->home();
    }

    public function operarSolicitud($solicitudId, $operacion, $animales)
    {
        $mascotas = new MascotaDAO();
        $arrayMascotas = $mascotas->getArrayByIds($animales);

        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            if ($operacion == "aceptar") {
                $solicitud = new SolicitudDAO();
                $solicitudXmasc = new SolixMascDAO();

                $soli = $solicitud->GetById($solicitudId);
                $pagos = new PagoDAO();
                $pago = new Pago($soli, $_SESSION["loggedUser"]);
                $solicitud->updateAPagoById($soli->getId()); //podemos ver si bien
                $pagos->Add($pago); //podemos ver si bien

                //if ($resul && $resul2) { ///arreglar esto
                $alert = new Alert("success", "Solicitud aceptada");
                //} else {
                //    $alert = new Alert("warning", "No se borro alguna solicitud");
                //}
            } else if ($operacion == "rechazar") {

                $solicitud = new SolicitudDAO();
                $solicitudXmasc = new SolixMascDAO();
                $resul = $solicitud->removeSolicitudById($solicitudId);
                $resul2 = $solicitudXmasc->removeSolicitudMascIntByIdSolicitud($solicitudId);

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
