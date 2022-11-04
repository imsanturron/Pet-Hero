<?php
include('nav-bar.php');

use Config\Autoload as Autoload;
//use DAO\JSON\MascotaDAO;
use DAO\MYSQL\MascotaDAO;
use DAO\MYSQL\SolicitudDAO;
use DAO\MYSQL\PagoDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;
use Models\Mascota as Mascota;
use Models\Pago as Pago;

if (isset($_SESSION['loggedUser'])) { ///CAMBIAR
    if ($_SESSION['tipo']  == 'g') {
        $guardian = $_SESSION['loggedUser'];
        $pago = new PagoDAO();
        $solicitud = new SolicitudDAO();
        $solis = $solicitud->getSolicitudesByDniGuardian($guardian->getDni()); ///get all by id desp
        $pagos = $pago->getPagosByDniGuardian($guardian->getDni());
        /*$mascota = new MascotaDAO(); ///get all by id desp
        $mascotas = $mascota->GetAll(); ///get all by id desp
        //$mascotas = $mascota->getMascotasByIdSolicitud();
        $mascXsoliDAO = new SolixMascDAO();
        $mascXsoli = $mascXsoliDAO->GetAll();
        $ingreso = false; //SIRVE PARA VERIFICAR SI EL DUEÑO TIENE ALGUNA SOLICITUD*/
    } else {
        $dueno = $_SESSION['loggedUser'];
        $pago = new PagoDAO();
        $solicitud = new SolicitudDAO();
        $solis = $solicitud->getSolicitudesByDniDueno($dueno->getDni()); ///get all by id desp
        //$solis = $solicitudes->GetAll(); ///get all by id desp
        $pagos = $pago->getPagosByDniDueno($dueno->getDni());
        /*$mascota = new MascotaDAO(); ///get all by id desp
        $mascotas = $mascota->GetAll(); ///get all by id desp
        //$mascotas = $mascota->getMascotasByIdSolicitud();
        $mascXsoliDAO = new SolixMascDAO();
        $mascXsoli = $mascXsoliDAO->GetAll();
        $ingreso = false; //SIRVE PARA VERIFICAR SI EL DUEÑO TIENE ALGUNA SOLICITUD */
    }
}
?>

<main class="py-5">
    <?php if (isset($_SESSION['loggedUser'])) { ?>
        <section id="listado" class="mb-5">
            <div class="container">
                <h2 class="mb-4">Listado de pagos pendientes:</h2>
                <table class="table bg-light-alpha">
                    <thead>
                        <th>Id unico del pago</th>
                        <th>Nombre guardian</th>
                        <th>Nombre dueño</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Direccion de guarda</th>
                        <th>Precio total</th>
                        <th>Monto a pagar actual</th>
                        <th>Forma de pago</th>
                        <th>Primer pago realizado (confirma reserva)</th>
                        <th>Pago final realizado</th>
                        <th>Opcion</th>
                    </thead>
                    <tbody>
                        <?php if (isset($_SESSION['loggedUser']) && $_SESSION['tipo']  == 'd') { ?>
                            <form action="<?php echo FRONT_ROOT ?>Dueno/realizarPago" method="POST">
                            <?php } ?>
                            <?php
                            if (isset($pagos) && !empty($pagos)) {

                                foreach ($pagos as $pago) {
                                    $soli = $solicitud->GetById($pago->getId());
                            ?>
                                    <tr>
                                        <td><?php echo $pago->getId(); //ver si cambiar por numero grande
                                            ?></td>
                                        <td><?php echo $soli->getNombreDueno(); ?></td>
                                        <td><?php echo $soli->getNombreGuardian(); ?></td>
                                        <td><?php echo $soli->getFechaInicio(); ?></td>
                                        <td><?php echo $soli->getFechaFin(); ?></td>
                                        <td><?php echo $soli->getDireccionGuardian(); ?></td>
                                        <td><?php echo $pago->getPrecioGuardian(); ?></td>
                                        <td><?php echo $pago->getMontoAPagar(); ?></td>
                                        <?php if ($_SESSION['tipo']  == 'd' && $pago->getFormaDePago() == null) { ?>
                                            <td><select name="formaDePago" required>
                                                    <option value="credito"> Credito </option>
                                                    <option value="debito"> Debito </option>
                                                    <option value="efectivo"> Efectivo </option>
                                                    <option value="cheque"> Cheque </option>
                                                </select></td>
                                        <?php } else { ?>
                                            <td><?php echo $pago->getFormaDePago(); ?></td>
                                        <?php } ?>
                                        <td><?php echo $pago->getPrimerPagoReserva(); ?></td>
                                        <td><?php echo $pago->getPagoFinal(); ?></td>
                                        <td>
                                            <?php if ($_SESSION["tipo"]  == "d") { ?>
                                                <input type="hidden" name="idSolicitud" value="<?php echo $soli->getId(); ?>">
                                                <input type="hidden" name="idPago" value="<?php echo $pago->getId(); ?>">
                                                <input type="hidden" name="primerPago" value="<?php echo $pago->getPrimerPagoReserva(); ?>">
                                                <button type="submit" name="operacion" value="pagar" class="btn btn-danger" ?> Pagar </button>
                                                <?php if ($pago->getPrimerPagoReserva() == null) { ?>
                                                    <button type="submit" name="operacion" value="cancelar" class="btn btn-danger" ?> Cancelar </button>
                                            <?php }
                                            } ?>
                                        </td>
                                    </tr>
                        <?php

                                }
                            }
                        } else
                            echo "<h2>No tiene pagos pendientes!</h2>";
                        ?>
                            </form>
                    </tbody>
                </table>
            </div>
        </section>
</main>