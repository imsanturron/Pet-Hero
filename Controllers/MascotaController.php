<?php

namespace Controllers;

use Exception;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DateTime as DateTime;
use Models\Alert as Alert;
use Models\Mascota as Mascota;

class MascotaController
{
    private $mascotaDAO;

    public function __construct()
    {
        $this->mascotaDAO = new MascotaDAO();
    }

    public function Index(Alert $alert = null)
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function loginDueno()
    {
        require_once(VIEWS_PATH . "loginDueno.php");
    }

    /* Agrega y guarda una nueva mascota. Varias validaciones en los files. */
    public function Add($especie, $nombre, $raza, $tamano, $fotoM, $planVacunacion, $video = null, $observaciones = "")
    {
        $error = false;
        if (isset($_SESSION["loggedUser"]) && $_SESSION["tipo"] == "d") {

            $bytes = bin2hex(random_bytes(20));
            $fotoM = $bytes . '_' . basename($_FILES['fotoM']['name']);
            $filenameFM = ROOT . IMG_PATH . $fotoM;

            $extension = strtolower(pathinfo($_FILES['fotoM']['name'], PATHINFO_EXTENSION));

            if (strcmp($extension, 'jpg') == 0 || strcmp($extension, 'png') == 0) {

                $sizeFM = $_FILES['fotoM']['size'];

                if ($sizeFM > 1000000) { //1mb
                    $error = true;
                } else {
                    if (move_uploaded_file($_FILES['fotoM']['tmp_name'], $filenameFM)) {
                    } else {
                        $error = true;
                        ///dar error desconocido podia ser carpeta no creada.
                    }
                }
            } else {
                $error = true;
            }

            if (file_exists($_FILES['planVacunacion']['tmp_name'])) {

                $bytes = bin2hex(random_bytes(20));
                $planVacunacion = $bytes . '_' . basename($_FILES['planVacunacion']['name']);
                $filenamePV = ROOT . IMG_PATH . $planVacunacion;

                $extension = strtolower(pathinfo($_FILES['planVacunacion']['name'], PATHINFO_EXTENSION));

                if (strcmp($extension, 'jpg') == 0 || strcmp($extension, 'png') == 0) {
                    $sizePV = $_FILES['planVacunacion']['size'];

                    if ($sizePV > 1000000) { // 1mb
                        $error = true;
                    } else {
                        if (move_uploaded_file($_FILES['planVacunacion']['tmp_name'], $filenamePV)) {
                        } else {
                            $error = true;
                            ///dar error desconocido, podia ser carpeta no creada
                        }
                    }
                } else {
                    $error = true;
                }
            }
            if ($video && file_exists($_FILES['video']['tmp_name'])) {
                $bytes = bin2hex(random_bytes(20));
                $video = $bytes . '_' . basename($_FILES['video']['name']);
                $filenameV = ROOT . VIDEO_PATH . $video;

                $extension = strtolower(pathinfo($_FILES['video']['name'], PATHINFO_EXTENSION));
                if (strcmp($extension, 'mp4') == 0) {
                    $sizeV = $_FILES['video']['size'];

                    if ($sizeV > 10000000) { //10mb
                        $error = true;
                    } else {
                        if (move_uploaded_file($_FILES['video']['tmp_name'], $filenameV)) {
                        } else {
                            $error = true;
                            ///dar error desconocido, podia ser carpeta no creada
                        }
                    }
                } else {
                    $error = true;
                }
            } else
                $video = null; //sino da error raro cuando no mando

            $mascota = new Mascota();
            $mascota->setDniDueno($_SESSION["dni"]);
            $mascota->setEspecie($especie); //desp? clase->pg
            $mascota->setNombre($nombre);
            $mascota->setRaza($raza);
            $mascota->setTamano($tamano);
            $mascota->setObservaciones($observaciones);
            $mascota->setFotoMascota($fotoM);
            $mascota->setPlanVacunacion($planVacunacion);
            $mascota->setVideo($video);

            try {
                $this->mascotaDAO->Add($mascota);
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->loginDueno($alert);
            }
            if ($error == false)
                $alert = new Alert("success", "Mascota agregada");
            else
                $alert = new Alert("warning", "Mascota agregada y error subiendo algun file");

            $this->loginDueno($alert);
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->Index($alert);
        }
    }

    /* Borrar una mascota */
    public function Remove($id)
    {
        if (isset($_SESSION["loggedUser"])) { 
            try {
                $bien = $this->mascotaDAO->removeMascotaById($id); 
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
                $this->loginDueno($alert);
            }
            if ($bien)
                $alert = new Alert("success", "Mascota borrada exitosamente");
            else
                $alert = new Alert("warning", "Error borrando la mascota");
            $this->loginDueno($alert);
        } else {
            $alert = new Alert("warning", "Debe iniciar sesion para acceder a sus funciones");
            $this->Index($alert);
        }
    }
}
