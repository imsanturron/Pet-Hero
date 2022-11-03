<?php
include('nav-bar.php');

use Config\Autoload as Autoload;
//use DAO\JSON\GuardianDAO as GuardianDAO;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\SolicitudDAO as SolicitudDAO;
use DAO\MYSQL\SolixMascDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;
use Models\Mascota as Mascota;

if (isset($_SESSION['loggedUser'])) { ///CAMBIAR
    if ($_SESSION['tipo']  == 'g') {
        $guardian = $_SESSION['loggedUser'];
        $solicitudes = new SolicitudDAO();
        //$solis = $solicitudes->GetAll(); 
        $solis = $solicitudes->getSolicitudesByDniGuardian($guardian->getDni());
        $mascota = new MascotaDAO(); 
        $mascotas = $mascota->GetAll(); 
        //$mascotas = $mascota->getMascotasByIdSolicitud();
        $mascXsoliDAO = new SolixMascDAO();
        $mascXsoli = $mascXsoliDAO->GetAll();
        $ingreso = false; //SIRVE PARA VERIFICAR SI EL DUEÑO TIENE ALGUNA SOLICITUD
    } else {
        $dueno = $_SESSION['loggedUser'];
        $solicitudes = new SolicitudDAO();
        //$solis = $solicitudes->GetAll(); 
        $solis = $solicitudes->getSolicitudesByDniDueno($dueno->getDni());
        $mascota = new MascotaDAO(); 
        $mascotas = $mascota->GetAll(); 
        $mascXsoliDAO = new SolixMascDAO();
        $mascXsoli = $mascXsoliDAO->GetAll();
        $ingreso = false; //SIRVE PARA VERIFICAR SI EL DUEÑO TIENE ALGUNA SOLICITUD
    }
} ?>

<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <?php if ($_SESSION['tipo'] == 'g') { ?>
                <h2 class="mb-4">Solicitudes de dueños</h2>
            <?php } else { ?>
                <h2 class="mb-4">Solicitudes enviadas</h2>
            <?php } ?>
            <table class="table bg-light-alpha">

                <?php if (isset($solis) && !empty($solis)) { ?>

                    <thead>
                        <th>Nombre Dueño</th>
                        <th>Nombre Guardian</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Direccion de guarda</th>
                       <? // <th>Mascotas de solicitud</th> ?>
                        <th>Especie</th>
                        <th>Nombre</th>
                        <th>Raza</th>
                        <th>Observaciones</th>
                        <th>Opcion</th>


                    </thead>
                    <tbody>
                        <?php if ($_SESSION['tipo'] == 'g') { ?>
                            <form action="<?php echo FRONT_ROOT ?>Guardian/operarSolicitud" method="POST">
                            <?php } else { ?>
                                <form action="<?php echo FRONT_ROOT ?>Dueno/cancelarSolicitud" method="POST">
                                <?php } ?>

                                <?php foreach ($solis as $solicitud) { ?>
                                    <tr>

                                        <td><?php echo $solicitud->getNombreDueno(); ?></td>
                                        <td><?php echo $solicitud->getNombreGuardian(); ?></td>
                                        <td><?php echo $solicitud->getFechaInicio(); ?></td>
                                        <td><?php echo $solicitud->getFechaFin(); ?></td>
                                        <td><?php echo $solicitud->getDireccionGuardian(); ?></td>
                                       <? // <td> <a href="<?php echo FRONT_ROOT ?><?//Home/verMascotasSoliRes/<?php echo $solicitud->getId(); ?> <? //"> Ver mascotas</a> </td> ?>

                                        <?php foreach ($mascXsoli as $tabla) { ?>

                                            <?php if ($tabla->getIdSolicitud() == $solicitud->getId()) {  ?>
                                                <input type="hidden" name="idIntermedia" value="<?php echo $tabla->getIdSolixMasc(); ?>">
                                                <?php $idMascotaX = $tabla->getIdMascota();  ?>
                                                <?php foreach ($mascotas as $masc) {
                                                    if ($masc->getId() == $idMascotaX) { ?>

                                                        <td><?php echo $masc->getEspecie(); ?></td>
                                                        <td><?php echo $masc->getNombre(); ?></td>
                                                        <td><?php echo $masc->getRaza(); ?></td>
                                                        <td><?php echo $masc->getObservaciones(); ?></td> <? //TAMAÑO Y FOTOS 
                                                                                                            ?>
                                                        <?php if ($_SESSION['tipo'] == 'g') { ?>
                                                            <input type="hidden" name="animales[]" value="<?php echo $masc->getId(); ?>">
                                                        <?php } ?>
                                        <?php }
                                                }
                                            }
                                        } ?>
                                        <td>
                                            <?php //<input type="hidden" name="dni" value="<?php echo $guardianx->getDni(); "> 
                                            ?>
                                            <input type="hidden" name="solicitudId" value="<?php echo $solicitud->getId(); ?>">
                                            <?php if ($_SESSION['tipo'] == 'g') { ?>
                                                <button type="submit" name="operacion" value="aceptar" class="btn btn-danger"> Aceptar </button>
                                                <button type="submit" name="operacion" value="rechazar" class="btn btn-danger"> Rechazar </button>
                                            <?php } else { ?>
                                                <button type="submit" class="btn btn-danger"> Cancelar </button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php  } ?>
                            <?php } else {
                            echo "NO TIENE SOLICITUDES";
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