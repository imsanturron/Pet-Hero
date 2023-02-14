<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
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
                            <form action="<?php echo FRONT_ROOT ?>Dueno/cargarTarjeta" method="POST">
                                <?php }

                            if (isset($pagos) && !empty($pagos)) {

                                foreach ($pagos as $pago) {
                                    $soli = $solicitud->GetById($pago->getId());
                                    if (!$soli)
                                        $reser = $reservas->GetById($pago->getId());
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
                                                </select></td>
                                        <?php } else { ?>
                                            <input type="hidden" name="formaDePago" value="credito">
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
                                                <button type="submit" name="operacion" value="pagar-<?php echo $pago->getId(); ?>-<?php echo $pago->getPrimerPagoReserva(); ?>" class="btn btn-danger" ?> Pagar </button>
                                                <?php if ($pago->getPrimerPagoReserva() == null || $pago->getPrimerPagoReserva() == false) { ?>
                                                    <button type="submit" name="operacion" value="cancelar-<?php echo $pago->getId(); ?>-<?php echo $pago->getPrimerPagoReserva(); ?>" class="btn btn-danger" ?> Cancelar </button>
                                                <?php } ?>
                                            </td>
                                        <?php
                                        } ?>
                                    </tr>
                        <?php

                                }
                            }
                        } else
                            echo "<h2>Inicia sesion!</h2>";
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