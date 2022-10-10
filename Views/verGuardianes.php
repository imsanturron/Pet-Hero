<?php

use Config\Autoload as Autoload;
use DAO\GuardianDAO as GuardianDAO;
use Models\Guardian as Guardian;

Autoload::Start();

$guardianDao = new GuardianDAO();
$listaguardianes = $guardianDao->GetAll();

?>
<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Listado de guardianes</h2>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Disponibilidad desde:</th>
                    <th>Hasta:</th>
                    <th>Precio</th>
                    <th>Direccion</th>
                    <th>Reputacion (falta)</th>
                </thead>
                <tbody>
                    <form action="<?php echo FRONT_ROOT ?>Dueno/ElegirG" method="POST">
                        <?php
                        if (isset($listaguardianes) && !empty($listaguardianes)) {

                            foreach ($listaguardianes as $guardianx) {
                        ?>
                                <tr>
                                    <td><?php echo $guardianx->getNombre(); ?></td>
                                    <td><?php echo $guardianx->getUserName(); ?></td>
                                    <td><?php echo $guardianx->getDisponibilidadInicio(); ?></td>
                                    <td><?php echo $guardianx->getDisponibilidadFin(); ?></td>
                                    <td><?php echo $guardianx->getPrecio(); ?></td>
                                    <td><?php echo $guardianx->getDireccion(); ?></td>
                                    <td><?php //php echo $guardianx->getReputacion(); ?></td>
                                    <td>
                                        <button type="submit" name="btnRemove" class="btn btn-danger" value="123"> Elegir </button>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </form>
                </tbody>
            </table>
        </div>
    </section>

    <div class="container">
        <div class="bg-light-alpha p-1">
            <div class="row">
                <div class="col-lg-3">
                    <div class="form-group text-white">
                        <label for="" class="ml-1"><b>IMPORTE TOTAL FACTURADO</b></label>
                        <input type="text" value="<?php echo 23; ?>" class="form-control ml-1 text-strong" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>