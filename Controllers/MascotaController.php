<?php

namespace Controllers;

//use DAO\JSON\MascotaDAO as MascotaDAO;
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

    /*public function opcionMenuPrincipal($opcion)
    {
        $opcion = $_POST['opcion'];
        if ($opcion == "verm") {
            require_once(VIEWS_PATH . "verMascotas.php");
        } else if ($opcion == "agregarm"){
            require_once(VIEWS_PATH . "agregarMascotas.php");
        } else if($opcion == "verg"){
            require_once(VIEWS_PATH . "verGuardianes.php");
        }
    }*/

    public function loginDueno()
    {
        require_once(VIEWS_PATH . "loginDueno.php");
    }

    public function idFotoFechaYCheck($fotoM = "")
    {
        $a = DateTime::createFromFormat('U.u', microtime(true));
        $res = $a->format("m-d-Y H:i:s.u"); //files no pueden tener :
        $retorn = str_replace(' ', '', $res);
        //$imageFileType = strtolower(pathinfo($_FILES['fotoM']['name'], PATHINFO_EXTENSION));
        /*if ($_FILES["fotoM"]["size"] > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }*/
        return $retorn /*. '.' . $imageFileType*/;
    }

    public function Add($especie, $nombre, $raza, $tamano, $fotoM, $planVacunacion, $video = null, $observaciones = "")
    {
        if (isset($_SESSION["loggedUser"])) {

            $bytes = bin2hex(random_bytes(20));
            //$filename = ROOT . IMG_PATH . $this->idFotoFechaYCheck($fotoM)/* . basename($_FILES['fotoM']['name'])*/;
            //$filename = ROOT . IMG_PATH . $this->idFotoFechaYCheck() . '_' . basename($_FILES['fotoM']['name']);
            $fotoM = $bytes . '_' . basename($_FILES['fotoM']['name']);
            $filenameFM = ROOT . IMG_PATH . $fotoM;
            //echo "filename ---> " . $filenameFM;

            $extension = strtolower(pathinfo($_FILES['fotoM']['name'], PATHINFO_EXTENSION));
            //echo "<br>extension ---> " . $extension;

            if (strcmp($extension, 'jpg') == 0 || strcmp($extension, 'png')) {

                $sizeFM = $_FILES['fotoM']['size'];
                //echo "<br>sizeFM  ----> " . $sizeFM;

                if ($sizeFM > 1000000) { //1mb
                    echo "error 1";
                } else {
                    //$filename = ""
                    if (move_uploaded_file($_FILES['fotoM']['tmp_name'], $filenameFM)) {
                        //$fotoM = $this->idFotoFechaYCheck($fotoM)/* . basename($_FILES['fotoM']['name'])*/;
                    } else {
                        echo "error 2";
                        ///dar error desconocido, el q me diho q podia ser carpeta no creada
                    }
                }
            } else {
                echo "error 3";
                ///dar otro error
            }

            if (file_exists($_FILES['planVacunacion']['tmp_name'])) {

                $bytes = bin2hex(random_bytes(20));
                $planVacunacion = $bytes . '_' . basename($_FILES['planVacunacion']['name']);
                $filenamePV = ROOT . IMG_PATH . $planVacunacion;

                $extension = strtolower(pathinfo($_FILES['planVacunacion']['name'], PATHINFO_EXTENSION));

                if (strcmp($extension, 'jpg') == 0 || strcmp($extension, 'png')) {
                    $sizePV = $_FILES['planVacunacion']['size'];

                    if ($sizePV > 1000000) { // 1mb
                        echo "error 4";
                    } else {
                        if (move_uploaded_file($_FILES['planVacunacion']['tmp_name'], $filenamePV)) {
                            //$planVacunacion = $this->idFotoFechaYCheck($planVacunacion) . basename($_FILES['planVacunacion']['nanme']);
                        } else {
                            echo "error 5";
                            ///dar error desconocido, el q me diho q podia ser carpeta no creada
                        }
                    }
                } else {
                    echo "error 6";
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
                    } else {
                        if (move_uploaded_file($_FILES['video']['tmp_name'], $filenameV)) {
                            //$video = $this->idFotoFechaYCheck($fotoM) . basename($_FILES['fotoM']['name']);
                        } else {
                            echo "error 8";
                            ///dar error desconocido, el q me diho q podia ser carpeta no creada
                        }
                    }
                } else {
                    echo "error 9";
                }
            } else
                $video = null;
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

            $this->mascotaDAO->Add($mascota);
            $alert = new Alert("success", "Mascota agregada");
            $this->loginDueno($alert);
        } else
            $this->Index();
    }

    public function Remove($id)
    {
        if (isset($_SESSION["loggedUser"])) {
            $bien = $this->mascotaDAO->removeMascotaById($id); //modificar funcion
            if ($bien)
                $alert = new Alert("success", "Mascota borrada exitosamente");
            else
                $alert = new Alert("warning", "Error borrando la mascota");
            $this->loginDueno($alert);
        } else
            $this->Index();
    }
}
