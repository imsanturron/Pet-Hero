<?php
include('nav-bar.php');

use Config\Autoload as Autoload;
//use DAO\JSON\GuardianDAO as GuardianDAO;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\SolicitudDAO as SolicitudDAO;
use DAO\MYSQL\ReservaDAO as ReservaDAO;
use DAO\MYSQL\SolixMascDAO as solixMascDAO;
use DAO\MYSQL\ResxMascDAO as ResxMascDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;
use Models\Mascota as Mascota;

if (isset($_SESSION['loggedUser'])) { ///CAMBIAR
    if ($_SESSION['tipo'] == 'g') {
        $guardian = $_SESSION['loggedUser'];
        $reservas = new ReservaDAO();
        //$solis = $solicitudes->GetAll(); ///get all by id desp
        $ress = $reservas->getReservasByDniGuardian($guardian->getDni());
        $mascota = new MascotaDAO(); ///get all by id desp
        $mascotas = $mascota->GetAll(); ///get all by id desp
        //$mascotas = $mascota->getMascotasByIdSolicitud();
        $resXmascDAO = new ResxMascDAO();
        $mascXres = $resXmascDAO->GetAll();
        $ingreso = false; //SIRVE PARA VERIFICAR SI EL DUEÑO TIENE ALGUNA SOLICITUD
    } else {
        $dueno = $_SESSION['loggedUser'];
        $reservas = new ReservaDAO();
        //$solis = $solicitudes->GetAll(); ///get all by id desp
        $ress = $reservas->getReservasByDniDueno($dueno->getDni());
        $mascota = new MascotaDAO(); ///get all by id desp
        $mascotas = $mascota->GetAll(); ///get all by id desp
        //$mascotas = $mascota->getMascotasByIdSolicitud();
        $resXmascDAO = new ResxMascDAO();
        $mascXres = $resXmascDAO->GetAll();
        $ingreso = false; //SIRVE PARA VERIFICAR SI EL DUEÑO TIENE ALGUNA SOLICITUD
    }
} ?>

<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Reservas de dueños</h2>
            <table class="table bg-light-alpha">

                <?php if (isset($ress) && !empty($ress)) { ?>

                    <thead>
                        <th>Nombre Dueño</th>
                        <th>Nombre Guardian</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Direccion de guarda</th>
                        <th>Especie</th>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Observaciones</th>
                        <th>Opcion</th>


                    </thead>
                    <tbody> <? //cambiar action a ver info mascota/dueño o borrar 
                            ?>
                        <form action="<?php echo FRONT_ROOT ?>Guardian/operarSolicitud" method="POST">
                            <?php foreach ($ress as $reserva) { ?>
                                <tr>

                                    <td><?php echo $reserva->getNombreDueno(); ?></td>
                                    <td><?php echo $reserva->getNombreGuardian(); ?></td>
                                    <td><?php echo $reserva->getFechaInicio(); ?></td>
                                    <td><?php echo $reserva->getFechaFin(); ?></td>
                                    <td><?php echo $reserva->getDireccionGuardian(); ?></td>

                                    <?php foreach ($mascXres as $tabla) { ?>

                                        <?php if ($tabla->getIdSolicitud() == $reserva->getId()) {  ?>
                                            <?php $idMascotaX = $tabla->getIdMascota();  ?>
                                            <?php foreach ($mascotas as $masc) {
                                                if ($masc->getId() == $idMascotaX) { ?>

                                                    <td><?php echo $masc->getEspecie(); ?></td>
                                                    <td><?php echo $masc->getNombre(); ?></td>
                                                    <td><?php echo $masc->getRaza(); ?></td>
                                                    <td><?php echo $masc->getObservaciones(); ?></td> <? //TAMAÑO Y FOTOS 
                                                                                                        ?>
                                                    <input type="hidden" name="animales[]" value="<?php echo $masc->getId(); ?>">
                                    <?php }
                                            }
                                        }
                                    } ?>
                                    <td>
                                        <?php //<input type="hidden" name="dni" value="<?php echo $guardianx->getDni(); "> 
                                        ?>
                                        <input type="hidden" name="reservaId" value="<?php echo $reserva->getId(); ?>">
                                    </td>
                                </tr>
                            <?php  } ?>
                        <?php } else {
                        echo "NO TIENE RESERVAS";
                    } ?>

                        </form>
                    </tbody>
            </table>
        </div>
    </section>
    <div class="alert alert-<?php echo $alert->getTipo(); ?>">
        <?php echo $alert->getMensaje(); ?>
    </div>
    <div class="container">
        <div class="bg-light-alpha p-1">
            <div class="row">
                <div class="col-lg-3">

                </div>
            </div>
        </div>
    </div>
</main>