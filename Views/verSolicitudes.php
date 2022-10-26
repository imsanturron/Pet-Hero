<?php
include('nav-bar.php');

use Config\Autoload as Autoload;
use DAO\GuardianDAO as GuardianDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;

if (isset($_SESSION['loggedUser'])) {
    $guardian = $_SESSION['loggedUser'];
    $solicitudes = $guardian->getSolicitudes();
}
?>

<main class="py-5">

    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Solicitudes de dueños</h2>
            <table class="table bg-light-alpha">
                <?php if (isset($solicitudes) && !empty($solicitudes)) {
                ?>
                    <thead>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Opcion</th>

                    </thead>
                    <tbody>
                        <form action="<?php echo FRONT_ROOT ?>Guardian/operarSolicitud" method="POST">
                            <?php
                            foreach ($solicitudes as $solicitud) {
                            ?>
                                <tr>
                                    <td><?php echo $solicitud->getNombreDueno(); ?></td>
                                    <td><?php echo $solicitud->getDireccion(); ?></td>
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