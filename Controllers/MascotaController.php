<?php

namespace Controllers;

use DAO\MascotaDAO as MascotaDAO;
use DateTime;
use Models\Alert;
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

    public function idFotoFechaYCheck($fotoM)
    {
        $a = DateTime::createFromFormat('U.u', microtime(true));
        $res = $a->format("m-d-Y H:i:s.u");
        $retorn = str_replace(' ', '', $res);
        $imageFileType = strtolower(pathinfo($fotoM, PATHINFO_EXTENSION));
        /*if ($_FILES["fotoM"]["size"] > 50000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }*/
        return $retorn . $imageFileType;
    }

    public function Add($nombre, $raza, $tamano, $fotoM, $observaciones = "")
    {
        if (isset($_SESSION["loggedUser"])) {
            $fotoMUniq = IMG_PATH . $this->idFotoFechaYCheck($fotoM);
            if (move_uploaded_file($_FILES["fotoM"]["tmp_name"], $fotoMUniq)) {
                echo "The file " . htmlspecialchars(basename($_FILES["fotoM"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }

            ///preguntar si nombre o algo asi
            $mascota = new Mascota();
            $mascota->setDniDueno($_SESSION["loggedUser"]->getDni());
            $mascota->setNombre($nombre);
            $mascota->setRaza($raza);
            $mascota->setTamano($tamano);
            $mascota->setObservaciones($observaciones);
            $mascota->setFotoMascota($fotoMUniq);

            $this->mascotaDAO->Add($mascota);
            //$mascota->setDniDueno($_SESSION["loggedUser"]->addMascota($mascota)); y guardar 
            $alert = new Alert("success", "Mascota agregada");
            $this->loginDueno($alert);
        }
        $this->Index();
    }

    public function Remove($id)
    {
        if (isset($_SESSION["loggedUser"])) {
            $bien = $this->mascotaDAO->Remove($id); //modificar funcion
            ///y remover de dueño si la tiene
            if ($bien)
                $alert = new Alert("success", "Mascota borrada exitosamente");
            else
                $alert = new Alert("warning", "Error borrando la mascota");
            $this->loginDueno($alert);
        }
        $this->Index();
    }
}
