<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>

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

                        <th>Opcion</th>
                        <th>Nombre Dueño</th>
                        <th>Nombre Guardian</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Direccion de guarda</th>
                        <th>Nombre de mascota</th>
                        <th>Especie</th>
                        <th>Raza</th>
                        <th>Observaciones</th>

                    </thead>
                    <tbody>
                        <?php if ($_SESSION['tipo'] == 'g') { ?>
                            <form action="<?php echo FRONT_ROOT ?>Guardian/operarSolicitud" method="POST">
                            <?php } else { ?>
                                <form action="<?php echo FRONT_ROOT ?>Dueno/cancelarSolicitud" method="POST">
                                <?php } ?>

                                <?php foreach ($solis as $solicitud) {
                                    $count = 0;
                                ?>
                                    <?php foreach ($mascXsoli as $tabla) { ///no puede hacerse fuera de vista
                                        if ($tabla->getIdSolicitud() == $solicitud->getId()) {
                                            $idMascotaX = $tabla->getIdMascota();
                                            foreach ($mascotas as $masc) {
                                                if ($masc->getId() == $idMascotaX) {
                                                    $count++;
                                                }
                                            } //contar para hacer el rowspan
                                        }
                                    } ?>
                                    <tr>
                                        <td rowspan="<?php echo $count; ?>">
                                            <?php if ($_SESSION['tipo'] == 'g') { ?>
                                                <button type="submit" name="operacion" value="aceptar-<?php echo $solicitud->getId(); ?>" class="btn btn-danger"> Aceptar </button>
                                                <button type="submit" name="operacion" value="rechazar-<?php echo $solicitud->getId(); ?>" class="btn btn-danger"> Rechazar </button>
                                            <?php } else { ?>
                                                <button type="submit" name="solicitudId" value="<?php echo $solicitud->getId(); ?>" class="btn btn-danger"> Cancelar </button>
                                            <?php } ?>
                                        </td>
                                        <td rowspan="<?php echo $count; ?>"><?php echo $solicitud->getNombreDueno(); ?></td>
                                        <td rowspan="<?php echo $count; ?>"><?php echo $solicitud->getNombreGuardian(); ?></td>
                                        <td rowspan="<?php echo $count; ?>"><?php echo $solicitud->getFechaInicio(); ?></td>
                                        <td rowspan="<?php echo $count; ?>"><?php echo $solicitud->getFechaFin(); ?></td>
                                        <td rowspan="<?php echo $count; ?>"><?php echo $solicitud->getDireccionGuardian(); ?></td>


                                        <?php foreach ($mascXsoli as $tabla) {
                                            if ($tabla->getIdSolicitud() == $solicitud->getId()) {
                                                $idMascotaX = $tabla->getIdMascota();
                                                foreach ($mascotas as $masc) {
                                                    if ($masc->getId() == $idMascotaX) { ?>

                                                        <td><?php echo $masc->getNombre(); ?></td>
                                                        <td><?php echo $masc->getEspecie(); ?></td>
                                                        <td><?php echo $masc->getRaza(); ?></td>
                                                        <td><?php echo $masc->getObservaciones(); ?></td>
                                    </tr>
                <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    echo " <h4>NO HAY SOLICITUDES ENVIADAS!</h4>";
                ?>
                Si ha enviado una solicitud anteriormente, puede que esta haya sido aceptada y
                deba pagar su confirmacion.
            <?php  } ?>
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
<?php
require_once(VIEWS_PATH . "footer.php");
?>