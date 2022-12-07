<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Selecccione con quien desea chatear</h2>
            <br>
            <table class="table bg-light-alpha">
                <thead>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Opcion</th>
                </thead>
                <tbody>
                    <?php if ($_SESSION["tipo"] == 'd') { ?>
                        <form action="<?php echo FRONT_ROOT ?>Dueno/EnviarNuevoMensaje" method="POST">
                        <?php } else { ?>
                            <form action="<?php echo FRONT_ROOT ?>Guardian/EnviarNuevoMensaje" method="POST">
                            <?php } ?>
                            <?php
                            if (isset($listaguardianes) && !empty($listaguardianes)) {
                                foreach ($listaguardianes as $guardianx) {
                            ?>
                                    <tr>
                                        <td><?php echo $guardianx->getNombre(); ?></td>
                                        <td><?php echo $guardianx->getUserName(); ?></td>
                                        <td>
                                            <button type="submit" name="dni" value="<?php echo $guardianx->getDni(); ?>" class="btn btn-danger"> Elegir </button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo " <label><h2> no hay guardianes para chatear </label></h2> ";
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