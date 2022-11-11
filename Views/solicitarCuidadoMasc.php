<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');

use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\GuardianDAO as GuardianDAO;
use Models\Guardian as Guardian;

?>
<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Elegir mascotas a cuidar</h2>
            Recuerda, deberan ser de la misma raza <br>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Nombre</th>
                    <th>Raza</th>
                    <th>Tamaño</th>
                    <th>Observaciones</th>
                    <th>Foto</th>
                    <th>Seleccionar</th>
                </thead>
                <tbody>
                    <form action="<?php echo FRONT_ROOT ?>Dueno/ElegirGuardianFinal" method="POST">
                        <?php
                        if (isset($listaMascotas) && !empty($listaMascotas)) {

                            foreach ($listaMascotas as $mascota) {
                        ?>
                                <?php if ($mascota->getTamano() == $guardian->getTamanoACuidar()) { ?>
                                    <tr>
                                        <td><?php echo $mascota->getNombre(); ?></td>
                                        <td><?php echo $mascota->getRaza(); ?></td>
                                        <td><?php echo $mascota->getTamano(); ?></td>
                                        <td><?php echo $mascota->getObservaciones(); ?></td>
                                        <td><img src="<?php echo FRONT_ROOT . IMG_PATH . $mascota->getFotoMascota() ?>" style="width:120px;height:auto;"></td>
                                        <td>
                                            <input type="checkbox" name="animales[]" value="<?php echo $mascota->getId(); ?>">
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                            <input type="hidden" name="dni" value="<?php echo $dni ?>">
                            <input type="hidden" name="desde" value="<?php echo $desde ?>">
                            <input type="hidden" name="hasta" value="<?php echo $hasta ?>">
                            <button type="submit" class="btn btn-danger"> Enviar </button>
                        <?php
                        } else
                            echo "Primero debe cargar sus mascotas!";
                        ?>
                    </form>
                </tbody>
            </table>
        </div>
    </section>
    <?php
    require_once(VIEWS_PATH . "footer.php");
    ?>