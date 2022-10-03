<?php

namespace Controllers;

use DAO\MascotaDAO as MascotaDAO;
use Models\Mascota as Mascota;

class MascotaController
{
    private $mascotaDAO;

    public function __construct()
    {
        $this->mascotaDAO = new MascotaDAO();
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



    public function Add($nombre, $raza, $tamano, $observaciones = "")
    {
        $mascota = new Mascota();
        $mascota->setNombre($nombre);
        $mascota->setRaza($raza);
        $mascota->setTamano($tamano);
        $mascota->setObservaciones($observaciones);

        $this->mascotaDAO->Add($mascota);

        $this->loginDueno();
    }

    public function Remove($id)
    {
        $this->mascotaDAO->Remove($id);

        $this->loginDueno();
    }
}
