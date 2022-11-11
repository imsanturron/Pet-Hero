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

    public function Index($message = "")
    {
        require_once(VIEWS_PATH . "home.php");
    }

    public function loginDueno()
    {
        require_once(VIEWS_PATH . "loginDueno.php");
    }

    public function Add($especie, $nombre, $raza, $tamano, $fotoM, $planVacunacion, $video = null, $observaciones = "")
    {
        $error = false;
        if (isset($_SESSION["loggedUser"])) {

            $bytes = bin2hex(random_bytes(20));
            $fotoM = $bytes . '_' . basename($_FILES['fotoM']['name']);
            $filenameFM = ROOT . IMG_PATH . $fotoM;
            //echo "filename ---> " . $filenameFM;

            $extension = strtolower(pathinfo($_FILES['fotoM']['name'], PATHINFO_EXTENSION));
            //echo "<br>extension ---> " . $extension;

            if (strcmp($extension, 'jpg') == 0 || strcmp($extension, 'png') == 0) {

                $sizeFM = $_FILES['fotoM']['size'];
                //echo "<br>sizeFM  ----> " . $sizeFM;

                if ($sizeFM > 1000000) { //1mb
                    echo "error 1";
                    $error = true;
                } else {
                    //$filename = ""
                    if (move_uploaded_file($_FILES['fotoM']['tmp_name'], $filenameFM)) {
                        //$fotoM = $this->idFotoFechaYCheck($fotoM)/* . basename($_FILES['fotoM']['name'])*/;
                    } else {
                        echo "error 2";
                        $error = true;
                        ///dar error desconocido, el q me diho q podia ser carpeta no creada
                    }
                }
            } else {
                echo "error 3";
                $error = true;
                ///dar otro error
            }

            if (file_exists($_FILES['planVacunacion']['tmp_name'])) {

                $bytes = bin2hex(random_bytes(20));
                $planVacunacion = $bytes . '_' . basename($_FILES['planVacunacion']['name']);
                $filenamePV = ROOT . IMG_PATH . $planVacunacion;

                $extension = strtolower(pathinfo($_FILES['planVacunacion']['name'], PATHINFO_EXTENSION));

                if (strcmp($extension, 'jpg') == 0 || strcmp($extension, 'png') == 0) {
                    $sizePV = $_FILES['planVacunacion']['size'];

                    if ($sizePV > 1000000) { // 1mb
                        echo "error 4";
                        $error = true;
                    } else {
                        if (move_uploaded_file($_FILES['planVacunacion']['tmp_name'], $filenamePV)) {
                            //$planVacunacion = $this->idFotoFechaYCheck($planVacunacion) . basename($_FILES['planVacunacion']['nanme']);
                        } else {
                            echo "error 5";
                            $error = true;
                            ///dar error desconocido, el q me diho q podia ser carpeta no creada
                        }
                    }
                } else {
                    echo "error 6";
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
                        echo "error 7";
                        $error = true;
                    } else {
                        if (move_uploaded_file($_FILES['video']['tmp_name'], $filenameV)) {
                            //$video = $this->idFotoFechaYCheck($fotoM) . basename($_FILES['fotoM']['name']);
                        } else {
                            echo "error 8";
                            $error = true;
                            ///dar error desconocido, el q me diho q podia ser carpeta no creada
                        }
                    }
                } else {
                    echo "error 9";
                    $error = true;
                }
            } else
                $video = null; //sino da error raro cuando no mando
            ///preguntar si nombre o algo asi
            $mascota = new Mascota();
            $mascota->setDniDueno($_SESSION["loggedUser"]->getDni());
            $mascota->setEspecie($especie); ///ver si crear clase perro y gato
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
            }
            if ($error == false)
                $alert = new Alert("success", "Mascota agregada");
            else
                $alert = new Alert("warning", "Mascota agregada y error subiendo algun file");

            $this->loginDueno($alert);
        } else
            $this->Index();
    }

    public function Remove($id)
    {
        if (isset($_SESSION["loggedUser"])) { ///borrar tambien intermedias
            try {
                $bien = $this->mascotaDAO->removeMascotaById($id); //modificar funcion
            } catch (Exception $ex) {
                $alert = new Alert("warning", "error en base de datos");
            }
            if ($bien)
                $alert = new Alert("success", "Mascota borrada exitosamente");
            else
                $alert = new Alert("warning", "Error borrando la mascota");
            $this->loginDueno($alert);
        } else
            $this->Index();
    }
}
