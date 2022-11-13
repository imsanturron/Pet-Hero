<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');

use DAO\MYSQL\MascotaDAO as MascotaDAO;
use DAO\MYSQL\SolicitudDAO as SolicitudDAO;
use DAO\MYSQL\ReservaDAO as ReservaDAO;
use DAO\MYSQL\PagoDAO as PagoDAO;
use DAO\MYSQL\ResxMascDAO;
use DAO\MYSQL\SolixMascDAO as SolixMascDAO;
use Models\Guardian as Guardian;
use Models\Dueno as Dueno;
use Models\Mascota as Mascota;
use Models\Pago as Pago;
use Models\ResxMasc as ResXmasc;

if (isset($_SESSION['loggedUser'])) { ///CAMBIAR
    if ($_SESSION['tipo']  == 'g') {
        //$guardian = $_SESSION['loggedUser'];
        //$pago = new PagoDAO();
        //$solicitud = new SolicitudDAO();
        //$solis = $solicitud->getSolicitudesByDniGuardian($guardian->getDni()); ///get all by id desp
        // $pagos = $pago->getPagosByDniGuardian($guardian->getDni());
        // //$mascXsoliDAO = new SolixMascDAO();
        // $mascXsoli = $mascXsoliDAO->GetAll();
        // $mascXresDAO = new ResxMascDAO();
        //$mascXres = $mascXresDAO->GetAll();
        //$mascota = new MascotaDAO(); ///get all by id desp
        // $mascotas = $mascota->GetAll(); ///get all by id desp
        // $reservas = new ReservaDAO();
        // $ress = $reservas->getReservasByDniGuardian($guardian->getDni());

        //ya estaba comentado esto
        /*$mascota = new MascotaDAO(); ///get all by id desp
        $mascotas = $mascota->GetAll(); ///get all by id desp
        //$mascotas = $mascota->getMascotasByIdSolicitud();
        $mascXsoliDAO = new SolixMascDAO();
        $mascXsoli = $mascXsoliDAO->GetAll();
        $ingreso = false; //SIRVE PARA VERIFICAR SI EL DUEÑO TIENE ALGUNA SOLICITUD*/
    } else {
        ////$dueno = $_SESSION['loggedUser'];
        ////$pago = new PagoDAO();
        ////$solicitud = new SolicitudDAO();
        ////$solis = $solicitud->getSolicitudesByDniDueno($dueno->getDni()); ///get all by id desp
        ////$pagos = $pago->getPagosByDniDueno($dueno->getDni());
        ////$mascXsoliDAO = new SolixMascDAO();
        ////$mascXsoli = $mascXsoliDAO->GetAll();
        ////$mascota = new MascotaDAO(); ///get all by id desp
        ////$mascotas = $mascota->GetAll(); ///get all by id desp
        ////$reservas = new ReservaDAO();
        //// $ress = $reservas->getReservasByDniDueno($dueno->getDni());

        //ya estaba comentado esto
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
                ¡Atencion! Antes de realizado el primer pago, la reserva no sera confirmada.
                Seguira siendo de momento, una solicitud.
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
                        <th>Primer pago (confirma reserva)</th>
                        <th>Pago final de reserva</th>
                        <?php if ($_SESSION["tipo"]  == "d") { ?>
                            <th>Opcion</th>
                        <?php } ?>
                    </thead>
                    <tbody>
                        <?php if (isset($_SESSION['loggedUser']) && $_SESSION['tipo']  == 'd') { ?>
                            <form action="<?php echo FRONT_ROOT ?>Dueno/realizarPago" method="POST">
                                <?php }

                            if (isset($pagos) && !empty($pagos)) {

                                foreach ($pagos as $pago) {
                                    $soli = $solicitud->GetById($pago->getId());
                                    if (!$soli)
                                        $reser = $reservas->GetById($pago->getId());


                                    if ($soli) {
                                        foreach ($mascXsoli as $tabla) {

                                            if ($tabla->getIdSolicitud() == $soli->getId()) {
                                                $idMascotaX = $tabla->getIdMascota();
                                                foreach ($mascotas as $masc) {
                                                    if ($masc->getId() == $idMascotaX) { ?>
                                                        <input type="hidden" name="animales[]" value="<?php echo $masc->getId(); ?>">
                                                    <?php
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        foreach ($mascXres as $tabla) {

                                            if ($tabla->getIdReserva() == $reser->getId()) {
                                                $idMascotaX = $tabla->getIdMascota();
                                                foreach ($mascotas as $masc) {
                                                    if ($masc->getId() == $idMascotaX) { ?>
                                                        <input type="hidden" name="animales[]" value="<?php echo $masc->getId(); ?>">
                                    <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $pago->getId(); ?></td>
                                        <td><?php
                                            if ($soli)
                                                echo $soli->getNombreDueno();
                                            else
                                                echo $reser->getNombreDueno();
                                            ?></td>
                                        <td><?php
                                            if ($soli)
                                                echo $soli->getNombreGuardian();
                                            else
                                                echo $reser->getNombreGuardian();
                                            ?></td>
                                        <td><?php
                                            if ($soli)
                                                echo $soli->getFechaInicio();
                                            else
                                                echo $reser->getFechaInicio();
                                            ?></td>
                                        <td><?php
                                            if ($soli)
                                                echo $soli->getFechaFin();
                                            else
                                                echo $reser->getFechaFin();
                                            ?></td>
                                        <td><?php
                                            if ($soli)
                                                echo $soli->getDireccionGuardian();
                                            else
                                                echo $reser->getDireccionGuardian();
                                            ?></td>
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
                                        <td>
                                            <?php
                                            if ($pago->getPrimerPagoReserva())
                                                echo "Realizado";
                                            else
                                                echo "No realizado";
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($pago->getPagoFinal())
                                                echo "Realizado";
                                            else
                                                echo "No realizado";
                                            ?>
                                        </td>
                                        <?php if ($_SESSION["tipo"]  == "d") { ?>
                                            <td>
                                                <?php if ($soli) { ?>
                                                    <input type="hidden" name="idSoliRes" value="<?php echo $soli->getId(); ?>">
                                                <?php } else { ?>
                                                    <input type="hidden" name="idSoliRes" value="<?php echo $reser->getId(); ?>">
                                                <?php } ?>
                                                <input type="hidden" name="idPago" value="<?php echo $pago->getId(); ?>">
                                                <input type="hidden" name="primerPago" value="<?php echo $pago->getPrimerPagoReserva(); ?>">
                                                <button type="submit" name="operacion" value="pagar" class="btn btn-danger" ?> Pagar </button>
                                                <?php if ($pago->getPrimerPagoReserva() == null || $pago->getPrimerPagoReserva() == false) { ?>
                                                    <button type="submit" name="operacion" value="cancelar" class="btn btn-danger" ?> Cancelar </button>
                                            </td>
                                    <?php }
                                            } ?>
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
<?php
require_once(VIEWS_PATH . "footer.php");
?>