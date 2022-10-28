<?php
include('nav-bar.php');
?>
<?php

use Config\Autoload as Autoload;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
//use DAO\JSON\GuardianDAO as GuardianDAO;
use Models\Guardian as Guardian;

$guardianDao = new GuardianDAO();
$listaguardianes = $guardianDao->GetAll();
?>

<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Listado de guardianes Disponibles</h2>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Disponibilidad</th>
                    <th>Precio</th>
                    <th>Direccion</th>
                    <th>Reputacion (falta)</th>
                    <th>Opcion</th>
                </thead>
                <tbody>
                    <form action="<?php echo FRONT_ROOT ?>Dueno/ElegirGuardian" method="POST">
                        <?php
                        $disponibilidad = false; //Sirve para alfinal verificar si habia guardianes o no en la fecha
                        if (isset($listaguardianes) && !empty($listaguardianes)) {

                            foreach ($listaguardianes as $guardianx) {

                                if ($guardianx->getDisponibilidadInicio() <= $desde && $guardianx->getDisponibilidadFin() >= $hasta) {
                                    $disponibilidad = true;

                        ?>
                                    <tr>
                                        <td><?php echo $guardianx->getNombre(); ?></td>
                                        <td><?php echo $guardianx->getUserName(); ?></td>
                                        <td>
                                            <?php if ($guardianx->getDisponibilidadInicio()) {
                                                echo $guardianx->getDisponibilidadInicio() .
                                                    " hasta " . $guardianx->getDisponibilidadFin();
                                            } else {
                                                echo "no disponible";
                                            } ?>
                                        </td>
                                        <td><?php echo $guardianx->getPrecio(); ?></td>
                                        <td><?php echo $guardianx->getDireccion(); ?></td>
                                        <td><?php //php echo $guardianx->getReputacion(); 
                                            ?></td>
                                        <?php if ($guardianx->getDisponibilidadInicio()) { ?>
                                            <td>
                                                <input type="hidden" name="dni" value="<?php echo $guardianx->getDni(); ?>">
                                                <input type="hidden" name="desde" value="<?php echo $desde; ?>">
                                                <input type="hidden" name="hasta" value="<?php echo $hasta; ?>">
                                                <button type="submit" class="btn btn-danger">Elegir </button>
                                            </td>
                                    <?php }
                                    }
                                }
                                if ($disponibilidad == false) { ?>
                                    <label>
                                        <h2> no hay guadianes disponibles para la fecha indicada
                                        </h2>
                                    </label>

                                <?php } ?>

                            <?php } else {
                            echo " <label><h2>   no hay guadianes cargados en el sistema </label></h2> ";
                        }
                            ?>
                                    </tr>

                    </form>
                </tbody>
            </table>
            <div class="alert alert-<?php echo $alert->getTipo() ?>">
                <?php echo $alert->getMensaje() ?>
            </div>
        </div>
    </section>
</main>