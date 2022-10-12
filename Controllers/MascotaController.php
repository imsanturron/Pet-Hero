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


<<<<<<< HEAD
/*agrega nueva mascota*/
    public function Add($nombre, $raza, $tamano, $observaciones = "")
    {
        $mascota = new Mascota();
=======

    public function Add($nombre, $raza, $tamano, $observaciones = "")
    {
        ///preguntar si nombre o algo asi
        $mascota = new Mascota();
        $mascota->setDniDueno($_SESSION["loggedUser"]->getDni()); 
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
        $mascota->setNombre($nombre);
        $mascota->setRaza($raza);
        $mascota->setTamano($tamano);
        $mascota->setObservaciones($observaciones);

        $this->mascotaDAO->Add($mascota);
<<<<<<< HEAD

=======
        //$mascota->setDniDueno($_SESSION["loggedUser"]->addMascota($mascota)); y guardar 
        ///alerta buena
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
        $this->loginDueno();
    }

    public function Remove($id)
    {
<<<<<<< HEAD
        $this->mascotaDAO->Remove($id);

=======
        $this->mascotaDAO->Remove($id);//modificar funcion
        ///y remover de dueño si la tiene
        ///alerta buena
>>>>>>> 7d536500738db2b0e3a166f37745baa7420ebfe7
        $this->loginDueno();
    }
}
