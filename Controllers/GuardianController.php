<?php

namespace Controllers;

//use Exception;

use DAO\MYSQL\DuenoDAO as DuenoDAO;
use Models\Guardian;
use Models\Alert as Alert;
use Models\Solicitud as Solicitud;
use Models\Reserva as Reserva;
use Models\Chat as Chat;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\SolicitudDAO;
use DAO\MYSQL\UserDAO as UserDAO;
use DAO\MYSQL\ReservaDAO as ReservaDAO;
use DAO\MYSQL\SolixMascDAO as SolixMascDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\ResxMascDAO as ResxMascDAO;
use DAO\MYSQL\PagoDAO as PagoDAO;
use DAO\MYSQL\ChatDAO as ChatDAO;
use Models\Pago as pago;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php'; //no sacar
require 'phpmailer/src/PHPMailer.php'; //no sacar
require 'phpmailer/src/SMTP.php'; //no sacar

class GuardianController
{
    private $guardianDAO;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
    }

    public function Index(Alert $alert = null)
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

    public function EnviarNuevoMsjNoUsar($dni)
    {
        $this->EnviarNuevoMensaje($dni);
    }

    public function verReservas(Alert $alert = null)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            try {
                $guardianDAO = new GuardianDAO();
                $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                $reservas = new ReservaDAO();
                $ress = $reservas->getReservasByDniGuardian($guardian->getDni());
                $mascota = new MascotaDAO();
                $mascotas = $mascota->GetAll();
                $resXmascDAO = new ResxMascDAO();
                $mascXres = $resXmascDAO->GetAll();
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
            require_once(VIEWS_PATH . "verReservas.php");
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->home($alert);
        }
    }

    public function verSolicitudes(Alert $alert = null)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            try {
                $guardianDAO = new GuardianDAO();
                $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                $solicitudes = new SolicitudDAO();
                $solis = $solicitudes->getSolicitudesByDniGuardian($guardian->getDni());
                $mascota = new MascotaDAO();
                $mascotas = $mascota->GetAll();
                $mascXsoliDAO = new SolixMascDAO();
                $mascXsoli = $mascXsoliDAO->GetAll();
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
            require_once(VIEWS_PATH . "verSolicitudes.php");
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->home($alert);
        }
    }

    public function enviarEmail($dniDueno)
    {
        if (isset($_SESSION["loggedUser"])) {
            try {
                $duenoDAO = new DuenoDAO();
                $dueno = $duenoDAO->GetByDni($dniDueno);
                $mail = new PHPMailer();
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'suppethero@gmail.com';                     //SMTP username
                $mail->Password   = 'pbohmjcvvusrddwx';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                $mail->setFrom('suppethero@gmail.com', 'Pet Hero');
                $mail->addAddress($dueno->getEmail());
                $mail->Subject = 'Cupon de Pago - Pet Hero';
                $mail->Body = "Hola " . $dueno->getNombre() . "! Han aceptado una solicitud que ha enviado, y
                su pago esta pendiente para confirmacion. Gracias por utilizar Pet Hero!";
                //problema en body para enviar codigo html por parametro. Puede mejorarse el body pero se 
                //rompe patron MVC.
                $mail->IsHTML(true);
                $mail->send();
                return true;
                //$alert = new Alert("success", "email enviado");
                //$this->login($alert);
            } catch (Exception $e) {
                $alert = new Alert("warning", "Problema enviando el email");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->home($alert);
        }
    }

    /* agregar y guardar nuevo guardian */
    public function Add($username, $password, $nombre, $dni, $email, $direccion, $telefono, $precio, $tamanoMasc)
    {
        $valid = AuthController::ValidarUsuario($username, $dni, $email, $telefono);
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

            try {
                $this->guardianDAO->add($guardian);
                $userDAO = new UserDAO;
                $userDAO->Add($guardian);
                $alert = new Alert("success", "Usuario creado");
                $this->home($alert);
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
            }
        } else {
            $alert = new Alert("warning", "Error! Este usuario ya existe");
            $this->home($alert);
        }
    }

    /* Menu principal de guardian */
    public function opcionMenuPrincipal($opcion) ///cambiar tamaño mascota a cuidar
    {
        ///alerta de disp obs...?
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            $opcion = $_POST['opcion'];
            try {
                if ($opcion == "indicarDisponibilidad") {
                    require_once(VIEWS_PATH . "indicarDisponibilidad.php");
                } else if ($opcion == "verListadReservas") {
                    $guardianDAO = new GuardianDAO();
                    $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                    $reservas = new ReservaDAO();
                    $ress = $reservas->getReservasByDniGuardian($guardian->getDni());
                    $mascota = new MascotaDAO();
                    $mascotas = $mascota->GetAll();
                    $resXmascDAO = new ResxMascDAO();
                    $mascXres = $resXmascDAO->GetAll();
                    require_once(VIEWS_PATH . "verReservas.php");
                } else if ($opcion == "verPerfil") {
                    ///sin terminar
                    require_once(VIEWS_PATH . "perfilGuardian.php");
                } else if ($opcion == "verSolicitudes") {
                    $envio = array();
                    $guardianDAO = new GuardianDAO();
                    $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                    $solicitudes = new SolicitudDAO();
                    $solis = $solicitudes->getSolicitudesByDniGuardian($guardian->getDni());
                    $mascota = new MascotaDAO();
                    $mascotas = $mascota->GetAll();
                    $mascXsoliDAO = new SolixMascDAO();
                    $mascXsoli = $mascXsoliDAO->GetAll();
                    if (isset($solis) && !empty($solis)) {
                        foreach ($solis as $solicitud) {
                            if ($solicitud->getEsPago() == false || $solicitud->getEsPago() == null) {
                                array_push($envio, $solicitud);
                            }
                        }
                    }
                    $solis = $envio;
                    require_once(VIEWS_PATH . "verSolicitudes.php");
                } else if ($opcion == "verPrimerosPagosPendientes") {
                    $envio = array();
                    $guardianDAO = new GuardianDAO();
                    $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                    $pago = new PagoDAO();
                    $solicitud = new SolicitudDAO();
                    $solis = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());
                    $pagos = $pago->getPagosByDniGuardian($guardian->getDni());
                    $mascXsoliDAO = new SolixMascDAO();
                    $mascXsoli = $mascXsoliDAO->GetAll();
                    $mascXresDAO = new ResxMascDAO();
                    $mascXres = $mascXresDAO->GetAll();
                    $mascota = new MascotaDAO();
                    $mascotas = $mascota->GetAll();
                    $reservas = new ReservaDAO();
                    $ress = $reservas->getReservasByDniGuardian($guardian->getDni());
                    if (isset($pagos) && !empty($pagos)) {
                        foreach ($pagos as $pag) {
                            if (($pag->getPrimerPagoReserva() == false || $pag->getPrimerPagoReserva() == null)
                                || ($pag->getPagoFinal() == false || $pag->getPagoFinal() == null)
                            ) {
                                array_push($envio, $pag);
                            }
                        }
                    }
                    $pagos = $envio;
                    require_once(VIEWS_PATH . "pagosPendientes.php");
                } else if ($opcion == "cambiarTamanoACuidar") {
                    $guardianDAO = new GuardianDAO();
                    $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                    require_once(VIEWS_PATH . "cambiarTamanoACuidar.php");
                } else if ($opcion == "modificarDatos") {
                    require_once(VIEWS_PATH . "modificarDatos.php");
                } else if ($opcion == "historialDePagos") {
                    $envio = array();
                    $guardianDAO = new GuardianDAO();
                    $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                    $pago = new PagoDAO();
                    $solicitud = new SolicitudDAO();
                    $solis = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());
                    $pagos = $pago->getPagosByDniGuardian($guardian->getDni());
                    $mascXsoliDAO = new SolixMascDAO();
                    $mascXsoli = $mascXsoliDAO->GetAll();
                    $mascXresDAO = new ResxMascDAO();
                    $mascXres = $mascXresDAO->GetAll();
                    $mascota = new MascotaDAO();
                    $mascotas = $mascota->GetAll();
                    $reservas = new ReservaDAO();
                    $ress = $reservas->getReservasByDniGuardian($guardian->getDni());
                    if (isset($pagos) && !empty($pagos)) {
                        foreach ($pagos as $pag) {
                            if ($pag->getPrimerPagoReserva() == true && $pag->getPagoFinal() == true) {
                                array_push($envio, $pag);
                            }
                        }
                    }
                    $pagos = $envio;
                    require_once(VIEWS_PATH . "historialDePagos.php");
                } else if ($opcion == "enviarMensaje") {
                    $duenoDAO = new DuenoDAO();
                    $listaguardianes = $duenoDAO->GetAll(); //cambiar el lista GUARDIANES
                    require_once(VIEWS_PATH . "seleccionarGuardian.php");
                }
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->home($alert);
        }
    }

    /* El guardian podra cambiar su rango de disponibilidad para cuidar mascotas.
    En caso de cambiarlo se haran las validaciones pertinentes, como si la 
    fecha es valida, borrar solicitudes, solicitudes intermedias y pagos (primeros/solicitudes)
    que no coincidan con la nueva disponibilidad */
    public function elegirDisponibilidad($desde, $hasta, $noDisp = null)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            try {
                if ($noDisp) {
                    $guardianDAO = new GuardianDAO();
                    $guardian = new Guardian();
                    $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                    $soliXmasc = new SolixMascDAO();
                    $pagoDAO = new PagoDAO();
                    $solicitud = new SolicitudDAO();
                    $solicitudesABorrar = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());

                    if (isset($solicitudesABorrar) && !empty($solicitudesABorrar)) {
                        foreach ($solicitudesABorrar as $soli) {  //borrar intermedias
                            $soliXmasc->removeSolicitudMascIntByIdSolicitud($soli->getId());
                            if ($soli->getEsPago())
                                $pagoDAO->removePagoById($soli->getId());
                        }
                        $solicitud->removeSolicitudesByDniGuardian($guardian->getDni());
                    }
                    $guardianDAO->setDisponibilidadEnNull($guardian->getDni());
                    $alert = new Alert("success", "Actualizado a no disponible");
                    $this->login($alert);
                } else {
                    $valid = UtilsController::ValidarFecha($desde, $hasta); //arreglar
                    if ($valid) {
                        $guardian = new Guardian();
                        $guardianDAO = new GuardianDAO();
                        $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                        $bien = $this->guardianDAO->updateDisponibilidad($guardian->getDni(), $desde, $hasta);
                        if ($bien) {
                            $alert = new Alert("success", "Disponibilidad actualizada");
                            $solicitud = new SolicitudDAO(); //borrar solicitudes que no estan en mi nuevo rango disponible
                            $solicitudes = $solicitud->getSolicitudesByDniGuardian($guardian->getDni());
                            $solicitudXmasc = new SolixMascDAO();
                            $pagoDAO = new PagoDAO();
                            if (isset($solicitudes) && !empty($solicitudes)) {
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
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->home($alert);
        }
    }

    /* El guardian podra cambiar su tamaño aceptado para cuidar mascotas.
    En caso de cambiarlo se haran las validaciones pertinentes, como borrar
    solicitudes, solicitudes intermedias-mascotas y pagos(primeros/solicitudes)
    que no esten en el nuevo tamaño disponible. */
    public function cambiarTamanoAResguardar($tamanoMasc) //el tamaño sera siempre distinto al anterior
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            try {
                $guardian = new Guardian();
                $guardianDAO = new GuardianDAO();
                $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                $guardianDAO->updateTamanoACuidar($guardian->getDni(), $tamanoMasc);
                $solicitudDAO = new SolicitudDAO();
                $soliXmasc = new SolixMascDAO();
                $pagoDAO = new PagoDAO();

                $solicitudes = $solicitudDAO->getSolicitudesByDniGuardian($guardian->getDni());
                if (isset($solicitudes) && !empty($solicitudes)) {
                    foreach ($solicitudes as $soli) {  //borrar intermedias
                        $soliXmasc->removeSolicitudMascIntByIdSolicitud($soli->getId());
                        if ($soli->getEsPago())
                            $pagoDAO->removePagoById($soli->getId());
                    }
                    $solicitudDAO->removeSolicitudesByDniGuardian($guardian->getDni()); //borrar todas las solis de tamaño viejo
                    ////ver distinto tamaño en mascotas a cuidar
                }
                $alert = new Alert("success", "Tamano cambiado y solicitudes removidas");
                $this->login($alert);
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->home($alert);
        }
    }

    //Recibe el ultimo dni, no el que se elije arreglar
    public function EnviarNuevoMensaje($dni, $mensaje = null)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            try {
                if ($mensaje == null) {
                    $chatD = new ChatDAO();
                    $historialMensajes = $chatD->getHistorialChatsByDnis($dni, $_SESSION["dni"]);
                    require_once(VIEWS_PATH . "escribirMensaje.php");
                } else {
                    $guardianes = new GuardianDAO();
                    $guardian = $guardianes->getByDni($_SESSION["dni"]);
                    $duenoDAO = new DuenoDAO();
                    $dueno = $duenoDAO->GetByDni($dni);

                    $chat = new Chat($guardian, $dueno, $mensaje, 'g');
                    $chatD = new chatDAO();
                    $chatD->Add($chat);
                    $alert = new Alert("success", "Mensaje enviado!");
                    $this->EnviarNuevoMsjNoUsar($dni);
                }
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos 3");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
    }

    /* El guardian aceptara o rechazara una solicitud que le llegue por parte de
    un dueño. En caso de rechazarla se borrara la solicitud como tambien la intermedia
    de solicitudes-mascotas. Si se acepta, seguira siendo una solicitud, se le dotara de
    true en el atributo "esPago", y se creara un pago para que el dueño pueda realizar */
    public function operarSolicitud($operacion)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            try {
                $s = explode("-", $operacion);
                $operacion = $s[0];
                $solicitudId = $s[1];

                if ($operacion == "aceptar") {
                    $solicitudXmasc = new SolixMascDAO();
                    $idmascs = $solicitudXmasc->getAllIdMascotaByIdSolicitud($solicitudId);
                    $mascotas = new MascotaDAO();
                    $arrayMascotas = $mascotas->getArrayByIds($idmascs);
                    $solicitud = new SolicitudDAO();
                    $soli = $solicitud->GetById($solicitudId);

                    $valid = UtilsController::ValidarMismaRaza( //con mascotas que puede ya haber reservadas
                        $arrayMascotas,
                        $soli->getDniGuardian(),
                        $soli->getFechaInicio(),
                        $soli->getFechaFin()
                    );
                    $valid2 = UtilsController::VerifMascotaNoEstaReservadaEnFecha(
                        $arrayMascotas,
                        $soli->getFechaInicio(),
                        $soli->getFechaFin()
                    );

                    if ($valid && $valid2) {
                        $guardianDAO = new GuardianDAO();
                        $guardian = $guardianDAO->GetByDni($_SESSION["dni"]);
                        $this->enviarEmail($soli->getDniDueno());

                        $pagos = new PagoDAO();
                        $pago = new Pago($soli, $guardian);
                        $solicitud->updateAPagoById($soli->getId());
                        $pagos->Add($pago);

                        $alert = new Alert("success", "Solicitud aceptada y mail con cupon enviado,
                         pago pendiente para reservar");
                    } else {
                        //el guardian tiene mascotas incompatibles en la fecha o la mascota esta reservada
                        $solicitudXmasc->removeSolicitudMascIntByIdSolicitud($solicitudId);
                        $solicitud->removeSolicitudById($solicitudId);

                        $alert = new Alert("warning", "Tiene mascotas incompatibles en la fecha o la mascota esta reservada");
                    }
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
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->home($alert);
        }
    }


    /* borrar guardian */
    public function Remove($dni)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "g") {
            try {
                $bien = $this->guardianDAO->removeGuardianByDni($dni);
                $userDAO = new UserDAO;
                $bien2 = $userDAO->removeUserByDni($dni);
                if ($bien && $bien2)
                    $alert = new Alert("success", "Usuario borrado exitosamente");
                else
                    $alert = new Alert("warning", "Error borrando el usuario");
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
            $this->home($alert);
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->home($alert);
        }
    }
}
