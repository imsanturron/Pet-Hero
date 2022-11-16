<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');

use DAO\MYSQL\GuardianDAO as GuardianDAO;
use Models\Guardian as Guardian;
?>

<main class="py-5">
    <a href="<?php echo FRONT_ROOT ?>Dueno/volverAVerFechasNoUsar"> Toca para volver a buscar </a>
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Listado de guardianes Disponibles</h2>
            Recuerda, solo puedes enviar una solicitud al mismo guardian <br>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Disponibilidad</th>
                    <th>Precio</th>
                    <th>Direccion</th>
                    <th>Tamaño aceptado</th>
                    <th>Cantidad de reseñas</th>
                    <th>Reputacion (1-100)</th>
                    <th>Opcion</th>
                </thead>
                <tbody>
                    <form action="<?php echo FRONT_ROOT ?>Dueno/ElegirGuardian" method="POST">
                        <?php
                        if (isset($listaguardianes) && !empty($listaguardianes)) {
                            foreach ($listaguardianes as $guardianx) {
                        ?>
                                <tr>
                                    <td><?php echo $guardianx->getNombre(); ?></td>
                                    <td><?php echo $guardianx->getUserName(); ?></td>
                                    <td>
                                        <?php
                                        echo $guardianx->getDisponibilidadInicio() .
                                            " hasta " . $guardianx->getDisponibilidadFin();
                                        ?>
                                    </td>
                                    <td><?php echo $guardianx->getPrecio(); ?></td>
                                    <td><?php echo $guardianx->getDireccion(); ?></td>
                                    <td><?php echo $guardianx->getTamanoACuidar(); ?></td>
                                    <td><?php echo $guardianx->getCantResenas(); ?></td>
                                    <td><?php
                                        if ($guardianx->getCantResenas() != 0 && $guardianx->getCantResenas())
                                            echo $guardianx->getPuntajePromedio();
                                        else
                                            echo "Sin reseñas";
                                        ?></td>
                                    <td>
                                        <input type="hidden" name="dni" value="<?php echo $guardianx->getDni(); ?>">
                                        <input type="hidden" name="desde" value="<?php echo $desde; ?>">
                                        <input type="hidden" name="hasta" value="<?php echo $hasta; ?>">
                                        <button type="submit" class="btn btn-danger">Elegir </button>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo " <label><h2> no hay guadianes disponibles para la fecha indicada </label></h2> ";
                        }
                        ?>
                    </form>
                </tbody>
            </table>
            <div class="alert alert-<?php echo $alert->getTipo() ?>">
                <?php echo $alert->getMensaje() ?>
            </div>
        </div>
    </section>
</main>
<?php
require_once(VIEWS_PATH . "footer.php");
?>