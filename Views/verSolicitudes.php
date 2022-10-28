<?php
include('nav-bar.php');

use Config\Autoload as Autoload;
//use DAO\JSON\GuardianDAO as GuardianDAO;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\SolicitudDAO as SolicitudDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;

if (isset($_SESSION['loggedUser'])) { ///CAMBIAR
    $guardian = $_SESSION['loggedUser'];
    $solicitudes = new SolicitudDAO;
    $solis = $solicitudes->GetAll(); ///get all by id desp
    $mascota = new MascotaDAO(); ///get all by id desp
    $mascotas = $mascota->GetAll(); ///get all by id desp
}
?>

<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Solicitudes de dueños</h2>
            <table class="table bg-light-alpha">
                <?php if (isset($solis) && !empty($solis)) {
                ?>
                    <thead>
                        <th>Nombre Dueño</th>
                        <th>Nombre Guardian</th>
                        <th>Direccion de guarda</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <? foreach ($mascotas as $mas) {
                             if($mas->getIdSoliRes()) /*ver como hacer misma cant*/{ ?>
                            <th>Mascota</th>
                        <? }} ?>
                        <th>Opcion</th>

                    </thead>
                    <tbody>
                        <form action="<?php echo FRONT_ROOT ?>Guardian/operarSolicitud" method="POST">
                            <?php
                            foreach ($solis as $solicitud) {
                            ?>
                                <tr>
                                    <td><?php echo $solicitud->getNombreDueno(); ?></td>
                                    <td><?php echo $solicitud->getNombreGuardian(); ?></td>
                                    <td><?php echo $solicitud->getDireccionGuardian(); ?></td>
                                    <td><?php echo $solicitud->getFechaInicio(); ?></td>
                                    <td><?php echo $solicitud->getFechaFin(); ?></td>
                                    <?php foreach ($mascotas as $masc) {
                                         if($masc->getIdSoliRes() == $solicitud->getId()){  ?>
                                        <td><?php echo $masc->getEspecie(); ?></td>
                                        <td><?php echo $masc->getNombre(); ?></td>
                                        <td><?php echo $masc->getRaza(); ?></td>
                                        <td><?php echo $masc->getObservaciones(); //TAMAÑO Y FOTOS ?></td>
                                    <? } } ?>
                                    <td>
                                        <?php //<input type="hidden" name="dni" value="<?php echo $guardianx->getDni(); "> 
                                        ?>
                                        <input type="hidden" name="solicitudId" value="<?php echo $solicitud->getId(); ?>">
                                        <button type="submit" name="operacion" value="aceptar" class="btn btn-danger"> Aceptar </button>
                                        <button type="submit" name="operacion" value="rechazar" class="btn btn-danger"> Rechazar </button>
                                    </td>
                                </tr>
                            <?php } ?>

                        <?php } else {
                        echo "NO TIENE SOLICITUDES";
                    }
                        ?>

                        </form>
                    </tbody>
            </table>
        </div>
    </section>
    <div class="alert alert-<?php echo $alert->getTipo() ?>">
        <?php echo $alert->getMensaje() ?>
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