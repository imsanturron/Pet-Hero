<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Slecccione a que guardian desea enviarle un mensaje</h2>
        <br>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Nombre</th>
                    <th>Usuario</th>
                  
                    <th>Opcion</th>
                </thead>
                <tbody>
                    <form action="<?php echo FRONT_ROOT ?>Dueno/EnviarNuevoMensaje" method="POST">
                        <?php
                        if (isset($listaguardianes) && !empty($listaguardianes)) {
                            foreach ($listaguardianes as $guardianx) {
                        ?>
                                <tr>
                                    <td><?php echo $guardianx->getNombre(); ?></td>
                                    <td><?php echo $guardianx->getUserName(); ?></td>
                              
                                    <td>
                                        <input type="hidden" name="dni" value="<?php echo $guardianx->getDni(); ?>">
                                        <button type="submit" class="btn btn-danger">Elegir </button>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo " <label><h2> no hay guadianes registrados </label></h2> ";
                        }
                        ?>
                    </form>
                </tbody>
            </table>
         
        </div>
    </section>
</main>
<?php
require_once(VIEWS_PATH . "footer.php");
?>