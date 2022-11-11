<?php

namespace Controllers;

use Models\Dueno as Dueno;
use Models\Solicitud as Solicitud;
use Models\Guardian as Guardian;
use Models\Reserva as Reserva;
use Models\Alert as Alert;
use DAO\MYSQL\DuenoDAO as DuenoDAO;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\PagoDAO as PagoDAO;
use DAO\MYSQL\SolicitudDAO as SolicitudDAO;
use DAO\MYSQL\SolixMascDAO as SolixMascDAO;
use DAO\MYSQL\ResxMascDAO as ResxMascDAO;
use DAO\MYSQL\ReservaDAO as ReservaDAO;
use DAO\MYSQL\ResenaDAO as ResenaDao;
use DAO\MYSQL\UserDAO as UserDAO;
use Models\Pago;
use Models\Resena;
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
        $mascotasDao = new MascotaDAO();
        $listaMascotas = $mascotasDao->getMascotasByDniDueno($_SESSION['loggedUser']->getDni());
        require_once(VIEWS_PATH . "verMascotas.php");
    }

    public function volverAVerFechasNoUsar()
    {
        require_once(VIEWS_PATH . "filtrarPorFecha.php");
    }


    public function login(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "loginDueno.php");
    }

    public function registro(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "registroDueno.php");
    }

    public function home(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "home.php");
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

    public function opcionMenuPrincipal($opcion)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $opcion = $_POST['opcion'];

            if ($opcion == "verMascotas") {
                $mascotasDao = new MascotaDAO();
                $listaMascotas = $mascotasDao->getMascotasByDniDueno($_SESSION['loggedUser']->getDni());
                require_once(VIEWS_PATH . "verMascotas.php");

            } else if ($opcion == "agregarMascota") {
                require_once(VIEWS_PATH . "agregarMascotas.php");

            } else if ($opcion == "verGuardianes") {
                require_once(VIEWS_PATH . "filtrarPorFecha.php");

            } else if ($opcion == "verPerfil") {
                require_once(VIEWS_PATH . "perfilDueno.php");

            } else if ($opcion == "verSolicitudes") {
                $envio = array();
                $dueno = $_SESSION['loggedUser'];
                $solicitudes = new SolicitudDAO();
                $solis = $solicitudes->getSolicitudesByDniDueno($dueno->getDni());
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

            } else if ($opcion == "verReservas") {
                $dueno = $_SESSION['loggedUser'];
                $reservas = new ReservaDAO();
                $ress = $reservas->getReservasByDniDueno($dueno->getDni());
                $mascota = new MascotaDAO(); ///get all by id desp
                $mascotas = $mascota->GetAll(); ///get all by id desp
                $resXmascDAO = new ResxMascDAO();
                $mascXres = $resXmascDAO->GetAll();
                require_once(VIEWS_PATH . "verReservas.php");

            } else if ($opcion == "verSolicitudesAceptadasAPagar") {
                $dueno = $_SESSION['loggedUser'];
                $pago = new PagoDAO();
                $solicitud = new SolicitudDAO();
                $solis = $solicitud->getSolicitudesByDniDueno($dueno->getDni()); ///get all by id desp
                $pagos = $pago->getPagosByDniDueno($dueno->getDni());
                $mascXsoliDAO = new SolixMascDAO();
                $mascXsoli = $mascXsoliDAO->GetAll();
                $mascota = new MascotaDAO(); ///get all by id desp
                $mascotas = $mascota->GetAll(); ///get all by id desp
                $reservas = new ReservaDAO();
                $ress = $reservas->getReservasByDniDueno($dueno->getDni());
                require_once(VIEWS_PATH . "pagosPendientes.php");

            } else if ($opcion == "generarNuevaReview") {
                $dueno = $_SESSION['loggedUser'];
                $reservas = new ReservaDAO();
                $ress = $reservas->getReservasByDniDueno($dueno->getDni());
                $mascota = new MascotaDAO(); ///get all by id desp
                $mascotas = $mascota->GetAll(); ///get all by id desp
                $resXmascDAO = new ResxMascDAO();
                $mascXres = $resXmascDAO->GetAll();
                $guardianDAO = new GuardianDAO();
                require_once(VIEWS_PATH . "generarReview.php");
            }
        } else
            $this->home();
    }

    public function filtrarFechas($desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $envio = array();
            $valid = UtilsController::ValidarFecha($desde, $hasta); //arreglar
            if ($valid) {
                $guardianDao = new GuardianDAO();
                $listaguardianes = $guardianDao->GetAll();
                foreach($listaguardianes as $guardian){
                   if(UtilsController::ValidarFecha($guardian->getDisponibilidadInicio(), $desde)
                   && UtilsController::ValidarFecha($hasta, $guardian->getDisponibilidadFin()))
                   array_push($envio, $guardian);
                }
                $listaguardianes = $envio;
                require_once(VIEWS_PATH . "verGuardianes.php");
            } else {
                $alert = new Alert("warning", "Fecha invalida");
                $this->login($alert);
            }
        } else
            $this->home();
    }

    public function ElegirGuardian($dni, $desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $mascotasDao = new MascotaDAO();
            $listaMascotas = $mascotasDao->GetAll();
            $guardianes = new GuardianDAO();
            $guardian = $guardianes->getByDni($dni);
            require_once(VIEWS_PATH . "solicitarCuidadoMasc.php");
        } else
            $this->home();
    }

    public function ElegirGuardianFinal($animales, $dni, $desde, $hasta)
    {
        $mascotas = new MascotaDAO();
        $arrayMascotas = $mascotas->getArrayByIds($animales);
        //$guardian = new Guardian(); PARA IMPLEMENTAR EN OTROS LADOS
        //$guardian->setDireccion("asd")->setDni("dad")->setEmail("kasmkak");
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $valid = UtilsController::ValidarMismaRaza($arrayMascotas, $dni, $desde, $hasta); //chequear con mascotas q ya tenga
            $valid2 = UtilsController::VerifGuardianSoliNuestraRepetida($dni);
            $valid3 = UtilsController::VerifMascotaNoEstaReservadaEnFecha($arrayMascotas, $desde, $hasta);
            ///ver ocupacion de mascotas y de guardianes.
            if ($valid && $valid2 && $valid3) {

                $guardianes = new GuardianDAO();
                $guardian = $guardianes->getByDni($dni);

                $solicitud = new Solicitud($guardian, $_SESSION["loggedUser"], $desde, $hasta);
                $solicitudesD = new SolicitudDAO;

                $solicitudesD->Add($solicitud);
                $idSolicitud = $solicitudesD->GetIdByDniDuenoYGuardian($solicitud->getDniDueno(), $solicitud->getDniGuardian());
                $intermediaMascotasXsolicitud = new SolixMascDAO();
                $intermediaMascotasXsolicitud->add($arrayMascotas, $idSolicitud);

                $alert = new Alert("success", "Solicitud enviada!");
                $this->login($alert);
            } else {
                $alert = new Alert("warning", "Hubo un error");
                $this->login($alert);
            }
        } else
            $this->home();
    }

    public function cancelarSolicitud($solicitudId)
    {
        $solicitud = new SolicitudDAO();
        $solicitudXmasc = new SolixMascDAO();
        $resul = $solicitud->removeSolicitudById($solicitudId);
        $resul2 = $solicitudXmasc->removeSolicitudMascIntByIdSolicitud($solicitudId); //!//

        if ($resul && $resul2) {
            $alert = new Alert("success", "Solicitud borrada con exito");
        } else {
            $alert = new Alert("warning", "No se borro alguna solicitud");
        }
        $this->login($alert);
    }

    public function realizarPago($animales, $formaDePago, $idSoliRes, $idPago, $primerPago, $operacion) //revisar - hacer validaciones de pago tambien una vez que se paga
    {
        ///hacer vista cargar tarjeta
        //print_r($animales);
        //echo "<br> --> forma de pago: " . $formaDePago;
        $mascotas = new MascotaDAO();
        $arrayMascotas = $mascotas->getArrayByIds($animales);

        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            if ($operacion == "pagar") {
                $pago = new PagoDAO();

                if ($primerPago == false || $primerPago == null) {
                    $solicitud = new SolicitudDAO();
                    $solicitudXmasc = new SolixMascDAO();

                    $soli = $solicitud->GetById($idSoliRes);
                    $reserva = new Reserva($soli);
                    $reservaDAO = new ReservaDAO();
                    $reservaDAO->add($reserva);
                    $pago->updatePrimerPagoReservaById($idPago);
                    $resul2 = $solicitudXmasc->removeSolicitudMascIntByIdSolicitud($idSoliRes);
                    $resul = $solicitud->removeSolicitudById($idSoliRes);
                    $intermediaMascotasXreserva = new ResxMascDAO();
                    $intermediaMascotasXreserva->add($arrayMascotas, $idSoliRes);
                } else {
                    $pago->updatePagoFinalReservaById($idPago);
                }

                $pago->updateFormaDePagoReservaById($formaDePago, $idPago);
                ///HACER ALERTAS
                $this->login();
            } else if ($operacion == "cancelar") {
                $solicitud = new SolicitudDAO();
                $solicitudXmasc = new SolixMascDAO();
                $pago = new PagoDAO();
                $resul = $solicitud->removeSolicitudById($idSoliRes);
                $resul2 = $solicitudXmasc->removeSolicitudMascIntByIdSolicitud($idSoliRes);
                $resul3 = $pago->removePagoById($idPago);
                ///ver si mostrar si rechazo pago
                ///HACER ALERTAS
                $this->login();
            }
        }
    }

    public function crearResena($idReserva, $dniGuard, $operacion)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            if ($operacion == "crear") {
                ///ver si se le pasa atributo xq antes no andaba
                $_SESSION["dniguard"] = $dniGuard; ///cambiar luego pasando atributos de una
                $_SESSION["idreserva"] = $idReserva;
                require_once(VIEWS_PATH . "generarReviewAGuardianX.php"); //PREGUNTAR PROFE VARIABLES
                ///Y luego crear reseña, tambien persistir.
            } else if ($operacion == "noCrear") {
                $reservaDAO = new ReservaDAO();
                $reservaDAO->updateCrearResena($idReserva, false);
                $reservaDAO->updateResHechaOrechazada($idReserva, true);
            }
            $this->login();
        } else
            $this->login();
    }

    public function asentarResena($puntos, $observaciones)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $reservaDAO = new ReservaDAO();
            $reservaDAO->updateCrearResena($_SESSION["idreserva"], false);
            $reservaDAO->updateResHechaOrechazada($_SESSION["idreserva"], true);

            $guardianDAO = new GuardianDAO();
            $guardianDAO->updateCantResenasMas1($_SESSION["dniguard"]); //no cambiar el orden
            $guardianDAO->updatePuntajeTotalMasPuntaje($_SESSION["dniguard"], $puntos);
            $guardianDAO->updatePuntajePromedio($_SESSION["dniguard"]);
            $resenaDAO = new ResenaDAO();
            $dueno = new Dueno();
            $dueno = $_SESSION["loggedUser"];
            $resena = new Resena($_SESSION["idreserva"], $dueno->getDni(), $_SESSION["dniguard"], $puntos, $observaciones);
            $resenaDAO->Add($resena);
            $this->login();
        } else
            $this->login();
    }

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
