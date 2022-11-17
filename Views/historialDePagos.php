<?php
require_once(VIEWS_PATH . "header.php");
include('nav-bar.php');
?>

<main class="py-5">
    <?php if (isset($_SESSION['loggedUser'])) { ?>
        <section id="listado" class="mb-5">
            <div class="container">
                <h2 class="mb-4">Historial de reservas y pagos finalizados</h2>
                <table class="table bg-light-alpha">
                    <thead>
                        <th>Id unico del pago</th>
                        <th>Nombre guardian</th>
                        <th>Nombre dueño</th>
                        <th>Desde</th>
                        <th>Hasta</th>
                        <th>Direccion de guarda</th>
                        <th>Precio total</th>
                        <th>Montos individuales</th>
                        <th>Forma de pago</th>
                        <th>Primer pago (confirma reserva)</th>
                        <th>Pago final de reserva</th>
                    </thead>
                    <tbody>
                        <?php

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
                                    <td><?php echo $pago->getFormaDePago(); ?></td>
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
                                </tr>
                    <?php

                            }
                        }
                    } else
                        echo "<h2>No tiene reservas/pagos finalizados</h2>";
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