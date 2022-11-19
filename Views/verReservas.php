<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>

<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Mis reservas</h2>
            <table class="table bg-light-alpha">

                <?php if (isset($ress) && !empty($ress)) { ?>

                    <thead>
                        <th>Nombre Dueño</th>
                        <th>Nombre Guardian</th>
                        <th>Estado</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Direccion de guarda</th>
                        <th>Nombre de mascota</th>
                        <th>Especie</th>
                        <th>Raza</th>
                        <th>Observaciones</th>

                    </thead>
                    <tbody>
                        <?php foreach ($ress as $reserva) {
                            $count = 0;
                            foreach ($mascXres as $tabla) {
                                if ($tabla->getIdReserva() == $reserva->getId()) {
                                    $idMascotaX = $tabla->getIdMascota();
                                    foreach ($mascotas as $masc) {
                                        if ($masc->getId() == $idMascotaX) {
                                            $count++;
                                        }
                                    } //contar para hacer el rowspan
                                }
                            } ?>
                            <tr>

                                <td rowspan="<?php echo $count; ?>"><?php echo $reserva->getNombreDueno(); ?></td>
                                <td rowspan="<?php echo $count; ?>"><?php echo $reserva->getNombreGuardian(); ?></td>
                                <td rowspan="<?php echo $count; ?>"><?php echo $reserva->getEstado(); ?></td>
                                <td rowspan="<?php echo $count; ?>"><?php echo $reserva->getFechaInicio(); ?></td>
                                <td rowspan="<?php echo $count; ?>"><?php echo $reserva->getFechaFin(); ?></td>
                                <td rowspan="<?php echo $count; ?>"><?php echo $reserva->getDireccionGuardian(); ?></td>

                                <?php foreach ($mascXres as $tabla) {

                                    if ($tabla->getIdReserva() == $reserva->getId()) {
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
                            echo "NO TIENE RESERVAS ACTUALMENTE";
                        } ?>
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