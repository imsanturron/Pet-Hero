<?php
require_once(VIEWS_PATH . "header.php");
?>

<div class="div-login"><br>
    <h1 class="text-login">Datos de la tarjeta</h1>
</div>
<div class="div-login">
    <b>Seleccionar de mis tarjetas</b>
    <?php
    if (isset($tarjetas) && !empty($tarjetas)) {
    ?>
        <form action="<?php echo FRONT_ROOT ?>Dueno/realizarPago" method="post">
            <input type="hidden" name="formaDePago" value="<?php echo $formaDePago ?>" />
            <input type="hidden" name="operacion" value="<?php echo $operacion ?>" />
            <input type="hidden" name="idSoliResPag" value="<?php echo $idSoliResPag ?>" />
            <input type="hidden" name="primerPago" value="<?php echo $primerPago ?>" />
            <table class="table bg-light-alpha">
                <thead>
                    <th>Ultimos 4 digitos</th>
                    <th>Seleccionar</th>
                </thead>
                <?php
                foreach ($tarjetas as $tarj) {
                ?>
                    <tbody>
                        <td><?php echo (substr($tarj->getNumeroTarjeta(), -4)); ?></td>
                        <td><button class="btn-login btn" name="numeroTarj" value="<?php echo $tarj->getNumeroTarjeta(); ?>" type="submit">Seleccionar</button></td>
                    </tbody>
                <?php
                }
                ?>
            </table>
        </form>
    <?php
    }
    ?>
    <br><br><br>
    <b>Ingresar nueva tarjeta</b>
    <form action="<?php echo FRONT_ROOT ?>Dueno/realizarPago" method="post">

        <input type="hidden" name="formaDePago" value="<?php echo $formaDePago ?>" />
        <input type="hidden" name="operacion" value="<?php echo $operacion ?>" />
        <input type="hidden" name="idSoliResPag" value="<?php echo $idSoliResPag ?>" />
        <input type="hidden" name="primerPago" value="<?php echo $primerPago ?>" />
        <input name="numeroTarj" placeholder="Numero tarjeta*" pattern=".{16,16}" required title="16 numbers">
        <input class="input-login" type="text" name="nombreTarj" placeholder="Nombre* (como aparece en tarjeta)" minlength="2" required>
        <input class="input-login" type="number" name="Mvencimiento" placeholder="Mes vencimiento*" min="1" max="12" required>
        <input class="input-login" type="number" name="Avencimiento" placeholder="Año vencimiento*" min="1" max="99" required>
        <input class="input-login" type="number" name="codigoSeg" placeholder="Codigo de seguridad*" min="1" max="999" required>
        <button class="btn-login btn" type="submit">Aceptar</button>

    </form>
</div>
</div>
<?php
require_once(VIEWS_PATH . "footer.php");
?>