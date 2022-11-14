<?php

namespace Controllers;

use Exception;
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
use Models\User;

class DuenoController
{
    private $duenoDAO;

    public function __construct()
    {
        $this->duenoDAO = new DuenoDAO();
    }

    public function Index(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function verMascotas()
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            try {
                $mascotasDao = new MascotaDAO();
                $listaMascotas = $mascotasDao->getMascotasByDniDueno($_SESSION['loggedUser']->getDni());
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
            require_once(VIEWS_PATH . "verMascotas.php");
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
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

    /* Agregar y guardar un dueño */
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

            try {
                $this->duenoDAO->Add($dueno);
                $userDAO = new UserDAO;
                $userDAO->add($dueno);
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }

            $alert = new Alert("success", "Usuario creado");
            $this->home($alert);
        } else {
            $alert = new Alert("warning", "Error! Usuario ya existente");
            $this->home($alert);
        }
    }

    /* Menu de opciones del dueño */
    public function opcionMenuPrincipal($opcion)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            try {
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
                    $duenoDAO = new DuenoDAO();
                    $dueno = $duenoDAO->GetByDni($_SESSION["loggedUser"]->getDni());
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
                    $duenoDAO = new DuenoDAO();
                    $dueno = $duenoDAO->GetByDni($_SESSION["loggedUser"]->getDni());
                    $reservas = new ReservaDAO();
                    $ress = $reservas->getReservasByDniDueno($dueno->getDni());
                    $mascota = new MascotaDAO(); ///get all by id desp
                    $mascotas = $mascota->GetAll(); ///get all by id desp
                    $resXmascDAO = new ResxMascDAO();
                    $mascXres = $resXmascDAO->GetAll();
                    require_once(VIEWS_PATH . "verReservas.php");
                } else if ($opcion == "verSolicitudesAceptadasAPagar") {
                    $duenoDAO = new DuenoDAO();
                    $dueno = $duenoDAO->GetByDni($_SESSION["loggedUser"]->getDni());
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
                    $duenoDAO = new DuenoDAO();
                    $dueno = $duenoDAO->GetByDni($_SESSION["loggedUser"]->getDni());
                    $reservas = new ReservaDAO();
                    $ress = $reservas->getReservasByDniDueno($dueno->getDni());
                    $mascota = new MascotaDAO(); ///get all by id desp
                    $mascotas = $mascota->GetAll(); ///get all by id desp
                    $resXmascDAO = new ResxMascDAO();
                    $mascXres = $resXmascDAO->GetAll();
                    $guardianDAO = new GuardianDAO();
                    require_once(VIEWS_PATH . "generarReview.php");
                } else if ($opcion == "pruebas") {
                    $solicitudDAO = new SolicitudDAO();
                    $reservaDAO = new ReservaDAO();
                    //$solicitudes = $solicitudDAO->getPRUEBBA();
                    //$solicitudes = $solicitudDAO->GetByIdPrueba(1);
                    $reservas = $reservaDAO->GetById(1);
                    echo "<br> <br> <br> ----  ";
                    print_r($reservas);
                } else if ($opcion == "modificarDatos") {
                    require_once(VIEWS_PATH . "modificarDatosDueños.php");
                }
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
    }

    
    public function modificarDatos($username,$password,$nombre,$email,$direccion,$telefono)
    {

        $dueno = new Dueno();

        $dueno->setUsername($username);
        $dueno->setPassword($password);
        $dueno->setNombre($nombre);
        $dueno->setDni($_SESSION["loggedUser"]->getDni());
        $dueno->setEmail($email);
        $dueno->setDireccion($direccion);
        $dueno->setTelefono($telefono);

        
        $usuario = new User();
        $usuario->setUsername($username);
        $usuario->setPassword($password);
        $usuario->setEmail($email);
        $usuario->setTipo($_SESSION["loggedUser"]->getTipo());

        $users = new UserDAO();
       
       
        $this->duenoDAO->modificarPerfil($dueno);
        $users->modificarPerfil($usuario);
 
          
 
           
        echo '<script language="javascript">alert("Su perfil fue modificado");</script>';
        
        $this->login();

    }




    /* Verifica que las fechas solicitadas sean validas y busca los guardianes 
    disponibles en el rango seleccionado para mostrarlos como opcion */
    public function filtrarFechas($desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            $envio = array();
            $valid = UtilsController::ValidarFecha($desde, $hasta); //arreglar
            if ($valid) {
                try {
                    $guardianDao = new GuardianDAO();
                    $listaguardianes = $guardianDao->GetAll();
                    foreach ($listaguardianes as $guardian) {
                        if ($guardian->getDisponibilidadInicio() && $guardian->getDisponibilidadFin()) {
                            if (
                                UtilsController::ValidarFecha($guardian->getDisponibilidadInicio(), $desde)
                                && UtilsController::ValidarFecha($hasta, $guardian->getDisponibilidadFin())
                            )
                                array_push($envio, $guardian);
                        }
                    }
                    $listaguardianes = $envio;
                } catch (Exception $ex) {
                    $alert = new Alert("warning", "error en base de datos");
                    $this->login($alert);
                }
                require_once(VIEWS_PATH . "verGuardianes.php");
            } else {
                $alert = new Alert("warning", "Fecha invalida");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
    }

    /* Luego de seleccionar un guardian en la funcion anterior, muestra las mascotas
    nuestras que le queremos enviar en la solicitud para que cuide, y nos mostrara solo
    las que coincidan con el tamaño que el guardian acepta cuidar */
    public function ElegirGuardian($dni, $desde, $hasta)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            try {
                $envio = array();
                $mascotasDao = new MascotaDAO();
                $listaMascotas = $mascotasDao->getMascotasByDniDueno($_SESSION["loggedUser"]->getDni());
                $guardianes = new GuardianDAO();
                $guardian = $guardianes->getByDni($dni);
                if (isset($listaMascotas) && !empty($listaMascotas)) {
                    foreach ($listaMascotas as $mascota) {
                        if ($mascota->getTamano() == $guardian->getTamanoACuidar()) {
                            array_push($envio, $mascota);
                        }
                    }
                }
                $listaMascotas = $envio;
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
            require_once(VIEWS_PATH . "solicitarCuidadoMasc.php");
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
    }

    /* con la solicitud totalmente armada, verifica que las mascotas que hayamos
    seleccionado sean de la misma raza, que ese guardian no tenga otras solicitudes nuestras
    y que nuestras mascotas no esten ya reservadas en la fecha seleccionada. En caso
    exitoso, crea la solicitud y la intermedia de solicitudes x mascotas */
    public function ElegirGuardianFinal($animales, $dni, $desde, $hasta)
    {
        //$guardian = new Guardian(); PARA IMPLEMENTAR EN OTROS LADOS
        //$guardian->setDireccion("asd")->setDni("dad")->setEmail("kasmkak");
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            try {
                $mascotas = new MascotaDAO();
                $arrayMascotas = $mascotas->getArrayByIds($animales);
                $valid = UtilsController::ValidarMismaRaza($arrayMascotas, $dni, $desde, $hasta); //chequear con mascotas q ya tenga
                $valid2 = UtilsController::VerifGuardianSoliNuestraRepetida($dni); //ver si acepta pago
                $valid3 = UtilsController::VerifMascotaNoEstaReservadaEnFecha($arrayMascotas, $desde, $hasta);
                ///ver ocupacion de mascotas y de guardianes.
                if ($valid && $valid2 && $valid3) {

                    $guardianes = new GuardianDAO();
                    $guardian = $guardianes->getByDni($dni);

                    $duenoDAO = new DuenoDAO();
                    $dueno = $duenoDAO->GetByDni($_SESSION["loggedUser"]->getDni());

                    $solicitud = new Solicitud($guardian, $dueno, $desde, $hasta);
                    $solicitudesD = new SolicitudDAO;

                    $solicitudesD->Add($solicitud);
                    $idSolicitud = $solicitudesD->GetIdByDniDuenoYGuardian($solicitud->getDniDueno(), $solicitud->getDniGuardian());
                    $intermediaMascotasXsolicitud = new SolixMascDAO();
                    $intermediaMascotasXsolicitud->add($arrayMascotas, $idSolicitud);

                    $alert = new Alert("success", "Solicitud enviada!");
                    $this->login($alert);
                } else {
                    $mensaje = "";
                    if (!$valid)
                        $mensaje = "Selecciono distintas razas o el guardian ya cuida otras razas en la fecha ";
                    if (!$valid2)
                        $mensaje .= "- El guardian ya tiene solicitudes nuestra en la fecha ";
                    if (!$valid3)
                        $mensaje .= "- Alguna/s de sus mascotas esta reservada en esa fecha";

                    $alert = new Alert("warning", $mensaje);
                    $this->login($alert);
                }
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
    }

    /* Podremos cancelar solicitudes que hayamos enviado, se borrara tanto la
    solicitud como la tabla intermedia de solicitudes y mascotas */
    public function cancelarSolicitud($solicitudId)
    {
        try {
            $solicitud = new SolicitudDAO();
            $solicitudXmasc = new SolixMascDAO();
            $resul = $solicitud->removeSolicitudById($solicitudId);
            $resul2 = $solicitudXmasc->removeSolicitudMascIntByIdSolicitud($solicitudId); //!//
        } catch (Exception $ex) {
            $alert = new Alert("warning", "error en base de datos");
            $this->login($alert);
        }

        if ($resul && $resul2) {
            $alert = new Alert("success", "Solicitud borrada con exito");
        } else {
            $alert = new Alert("warning", "No se borro alguna solicitud");
        }
        $this->login($alert);
    }

    /* Funcion que sirve tanto para realizar el primero(confirmacion reserva)
     como el segundo pago final, y tambien la posibilidad de cancelar en caso de que
     no se haya realizado el primer pago. */
    public function realizarPago($animales, $formaDePago, $idSoliRes, $idPago, $primerPago, $operacion) //revisar - hacer validaciones de pago tambien una vez que se paga
    {
        ///hacer vista cargar tarjeta

        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            try {
                $mascotas = new MascotaDAO();
                $arrayMascotas = $mascotas->getArrayByIds($animales);
                if ($operacion == "pagar") {
                    $pago = new PagoDAO();

                    ///en caso de ser el primer pago...
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
                    } else { //en caso de hacer el pago final
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
                    if ($resul && $resul2 && $resul3)
                        $alert = new Alert("success", "Pago cancelado");
                    else
                        $alert = new Alert("success", "Error borrando algun pago o solicitud");

                    ///ver si mostrar si rechazo pago
                    ///HACER ALERTAS
                    $this->login($alert);
                }
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
    }

    /* Opcion de crear u no hacer una reseña a un guardian en el momento que una
     reserva haya finalizado. */
    public function crearResena($idReserva, $dniGuard, $operacion)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            if ($operacion == "crear") {
                $guardianDAO = new GuardianDAO; //NUEVO
                $guardian = $guardianDAO->GetByDni($dniGuard); //NUEVO
                $reservaDAO = new ReservaDAO(); //NUEVO
                $reserva = $reservaDAO->GetById($idReserva); //NUEVO
                ///ver si se le pasa atributo xq antes no andaba
                // ESTO ESTABA DESCOMENTADO$_SESSION["dniguard"] = $dniGuard; ///cambiar luego pasando atributos de una
                //ESTO ESTABA DESCOMENTADO $_SESSION["idreserva"] = $idReserva;
                require_once(VIEWS_PATH . "generarReviewAGuardianX.php"); //PREGUNTAR PROFE VARIABLES
                ///Y luego crear reseña, tambien persistir.
            } else if ($operacion == "noCrear") {
                try {
                    $reservaDAO = new ReservaDAO();
                    $reservaDAO->updateCrearResena($idReserva, false);
                    $reservaDAO->updateResHechaOrechazada($idReserva, true);
                } catch (Exception $ex) {
                    $alert = new Alert("warning", "error en base de datos");
                    $this->login($alert);
                }
            }
            $this->login();
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
    }

    /* En caso de haber querido realizar la reseña y haberla hecho anteriormente, se
    creara y guardara. Tambien se promediara el puntaje con las otras reseñas */
    public function asentarResena($idReserva, $dniGuard, $puntos, $observaciones) ///idr y dng agregados
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            try {
                $reservaDAO = new ReservaDAO();
                $reservaDAO->updateCrearResena($idReserva, false);
                $reservaDAO->updateResHechaOrechazada($idReserva, true);

                $guardianDAO = new GuardianDAO();
                $guardianDAO->updateCantResenasMas1($dniGuard); //no cambiar el orden
                $guardianDAO->updatePuntajeTotalMasPuntaje($dniGuard, $puntos);
                $guardianDAO->updatePuntajePromedio($dniGuard);
                $resenaDAO = new ResenaDAO();
                $dueno = new Dueno();
                $duenoDAO = new DuenoDAO();
                $dueno = $duenoDAO->GetByDni($_SESSION["loggedUser"]->getDni());
                $resena = new Resena($idReserva, $dueno->getDni(), $dniGuard, $puntos, $observaciones);
                $resenaDAO->Add($resena);
                $alert = new Alert("success", "review agregada exitosamente");

                /*$reservaDAO = new ReservaDAO();
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
                $resenaDAO->Add($resena);  Estaba esto */
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
            $this->login($alert);
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
    }

    /* Borrar dueño */
    public function Remove($dni)
    {
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {
            try {
                $bien = $this->duenoDAO->removeDuenoByDni($dni);
                $userDAO = new UserDAO;
                $bien2 = $userDAO->removeUserByDni($dni);
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->login($alert);
            }
            if ($bien && $bien2)
                $alert = new Alert("success", "Usuario borrado exitosamente");
            else
                $alert = new Alert("warning", "Error borrando el usuario");
            $this->home($alert);
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones!");
            $this->home($alert);
        }
    }
}
